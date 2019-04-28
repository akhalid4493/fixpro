<?php
namespace App\TheApp\Repository\Api\Previews;

use App\Notifications\PreviewToAdmin;
use App\Notifications\PreviewMail;
use App\Models\PreviewGallery;
use App\Models\PreviewDetail;
use App\Models\PreviewAddress;
use App\Models\PreviewDate;
use App\Models\Address;
use App\Models\Preview;
use App\Models\Service;
use Notification;
use ImageTrait;
use SendNotifi;
use Auth;
use DB;

class PreviewRepository
{
    use SendNotifi;

    function __construct(
        Service $service,
        Preview $preview,
        PreviewDetail $details,
        PreviewDate $date,
        PreviewGallery $gallery,
        PreviewAddress $preAddress,
        Address $address
    )
    {
        $this->model        = $preview;
        $this->modelDetails = $details;
        $this->modelService = $service;
        $this->modelGallery = $gallery;
        $this->modelDate    = $date;
        $this->modelAddress = $preAddress;
        $this->addressModel = $address;
    }  

    /*
        USER APP PREVIEWS METHODS
    */
    public function getServices()
    {
        $services = $this->modelService
               ->where('status',1)
               ->orderBy('id','desc')
               ->get();

        return $services;
    }

    public function userCreateRequest($request)
    {
        DB::beginTransaction();

        try {
            
            $preview = $this->model->create([
                'user_id'           => Auth::id(),
                'note'              => $request['note'],
                'time'              => $request['time'],
                'preview_status_id' => 1,
            ]);

            if ($preview){
                $this->createPreviewAddress($preview,$request);
                $this->createPreviewDetails($preview,$request);
                $this->createPreviewDates($preview,$request);
                $this->sendNotificationMail($preview);
                $this->fireLog($preview);
            }

            if ($request['image']) {
                foreach ($request['image'] as $img) {
                    $img = ImageTrait::uploadImage($img,'previews/'.ar_slug($preview->id));

                    $this->modelGallery->create([
                        'preview_id'        => $preview['id'],
                        'image'             => $img,
                    ]);
                }
            }

            DB::commit();
            return $preview;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function createPreviewAddress($preview,$request)
    {
        DB::beginTransaction();
        
        $address = $this->addressModel->find($request['address_id']);

        try {

            $address = $this->modelAddress->create([
                'lat'           => $address['lat'],
                'lang'          => $address['lang'],
                'province_id'   => $address['province_id'],
                'block'         => $address['block'],
                'street'        => $address['street'],
                'building'      => $address['building'],
                'floor'         => $address['floor'],
                'house_no'      => $address['house_no'],
                'note'          => $address['note'],
                'address'       => $address['address'],
                'user_id'       => Auth::user()->id,
                'preview_id'    => $preview['id'],
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function createPreviewDetails($preview,$request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['service_id'] as $service) {
                $this->modelDetails->create([
                    'service_id' => $service,
                    'preview_id' => $preview['id'],
                ]);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function createPreviewDates($preview,$request)
    {        
        DB::beginTransaction();
        
        try {

            foreach ($request['service_id'] as $service) {
                $this->modelDate->create([
                    'date'              => $request['time'],
                    'service_id'        => $service,
                    'preview_id'        => $preview['id'],
                    'governorate_id'    => $preview->address->addressProvince->governorate->id,
                ]);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
    
    public function myPreviews($request)
    {
        $previews = $this->model->where('user_id',Auth::id())->get();

        return $previews;
    }

    public function previewById($id)
    {
        $preview = $this->model->where('id',$id)->where('user_id',Auth::id())->first();

        return $preview;
    }

    /*
        TECHNICAL APP PREVIEWS METHODS
    */
    public function techPreviews($request)
    {
        $previews = Auth::user()->previewsOfTechnical;

        if ($previews) {
            return $previews;
        }

        return false;
    }

    public function techPreviewById($id)
    {
        $preview = $this->model
                    ->where('id',$id)
                    ->whereHas('technical', function($query){
                        $query->where('user_id',Auth::id());
                    })
                    ->first();

        return $preview;
    }

    public function previewChangeStatus($request,$id)
    {
        $preview = $this->techPreviewById($id);

        if ($preview) {

            $preview->update([
                'preview_status_id'  => $request['status'],
            ]);

            $this->sendNotifiToUser($preview);
            
            return $preview;
        }
         
        return false;   
    }

    public function sendNotifiToUser($preview)
    {
        $userToken = $preview->user->deviceToken;

        if (!empty($userToken)) {
            $data = [
                'type'  => 'previews',
                'id'    => $preview['id'],
                'title' => 'حالة الطلب الخاص بك',
                'body'  => 'تم تغير حالة الطلب الى: '.$preview->previewStatus->name_ar.''
            ];

            return $this->send($data,$userToken->device_token);
        }
    }

    public function sendNotificationMail($preview)
    {
        $user           = $preview->user;
        $user->email    = $user->email;
        $user->notify(new PreviewMail());
        Notification::route('mail', settings('receive_mail'))->notify(new PreviewToAdmin($preview));
    }

    public function fireLog($preview)
    {
        activity('previews')
        ->performedOn($preview)
        ->withProperties([
            'preview_id'        => $preview->id,
            'description_en'    => 'New Preview from : '.$preview->user->name.' ',
            'description_ar'    => 'لديك طلب معاينة جديد من :  '.$preview->user->name.' ',
        ])
        ->causedBy($preview->user)
        ->log('create');
    }
}
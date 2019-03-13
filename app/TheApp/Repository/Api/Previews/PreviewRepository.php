<?php
namespace App\TheApp\Repository\Api\Previews;

use App\Models\PreviewGallery;
use App\Models\PreviewDetail;
use App\Models\Preview;
use App\Models\Service;
use ImageTrait;
use Auth;
use DB;

class PreviewRepository
{
    protected $model;

    function __construct(
        Service $service,
        Preview $preview,
        PreviewDetail $details,
        PreviewGallery $gallery
    )
    {
        $this->model        = $preview;
        $this->modelDetails = $details;
        $this->modelService = $service;
        $this->modelGallery = $gallery;
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
                'user_id'           => Auth::user()->id,
                'address_id'        => $request['address_id'],
                'note'              => $request['note'],
                'time'              => $request['time'],
                'preview_status_id' => 1,
            ]);

            if ($preview)
                $this->createPreviewDetails($preview['id'],$request);

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

    public function myPreviews($request)
    {
        $previews = $this->model->where('user_id',Auth::user()->id)->get();

        return $previews;
    }

    public function previewById($id)
    {
        $preview = $this->model->where('id',$id)->where('user_id',Auth::user()->id)->first();

        return $preview;
    }

    /*
        TECHNICAL APP PREVIEWS METHODS
    */
    public function techPreviews($request)
    {
        return $previews = Auth::user()->previewsOfTechnical;

        return $previews;
    }

    public function previewChangeStatus($request,$id)
    {
        $preview = $this->model->find($id);

        if ($request['status'] == 'on_way') {
            $status = 3;
        }elseif ($request['status'] == 'reached') {
            $status = 7;
        }elseif ($request['status'] == 'success') {
            $status = 4;
        }

        $preview->update([
            'preview_status_id'  => $status,
        ]);

        $this->sendNotifiToUser($preview);
        
        return $preview;
    }

    public function sendNotifiToUser($preview)
    {
        $userToken = $preview->user->deviceToken;

        if (!empty($userToken)) {
            $data = [
                'title' => 'حالة الطلب الخاص بك',
                'body'  => 'تم تغير حالة الطلب الى: '.$preview->previewStatus->name_ar.''
            ];

            return $this->send($data,$userToken->device_token);
        }
    }

    public function createPreviewDetails($previewId,$request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['service_id'] as $service) {
                $this->modelDetails->create([
                    'service_id' => $service,
                    'preview_id' => $previewId,
                ]);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
}
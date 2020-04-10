<?php
namespace App\TheApp\Repository\Admin\Previews;

use App\TheApp\Libraries\ImgRepository;
use App\Models\TechnicalPreview;
use App\Models\PreviewAddress;
use App\Models\PreviewStatus;
use App\Models\PreviewDetail;
use App\Models\PreviewDate;
use App\Models\Address;
use App\Models\Preview;
use App\Models\Service;
use Carbon\Carbon;
use SendNotifi;
use Auth;
use DB;

class PreviewRepository
{
    use SendNotifi;

    function __construct(
        PreviewDetail $details,
        Service $service,
        Preview $preview,
        PreviewStatus $status,
        TechnicalPreview $tech,
        PreviewAddress $preAddress,
        Address $address,
        PreviewDate $date
    )
    {
        $this->model        = $preview;
        $this->modelStatus  = $status;
        $this->modelTech    = $tech;
        $this->modelDate    = $date;
        $this->modelDetails = $details;
        $this->modelService = $service;
        $this->modelAddress = $preAddress;
        $this->addressModel = $address;
    }

    public function countNewPreviews()
    {
        return $this->model->where('preview_status_id', 1)->count();
    }

    public function countDone()
    {
        return $this->model->where('preview_status_id',5)->count();
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    public function getAllStatus($order = 'id', $sort = 'desc')
    {
        return $this->modelStatus->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }


    public function create($request)
    {
        DB::beginTransaction();

        try {

            $preview = $this->model->create([
                'user_id'           => $request['user_id'],
                'note'              => $request['note'],
                'note_from_admin'   => $request['note_from_admin'],
                'time'              => $request->date .' '.date('H:i:s',strtotime($request->time)),
                'preview_status_id' => 1,
            ]);

            if ($preview){
                $this->createPreviewAddress($preview,$request);
                $this->createPreviewDetails($preview,$request);
                $this->createPreviewDates($preview,$request);
            }

            DB::commit();
            return true;

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
                'user_id'       => $address['user_id'],
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
                    'date'              => $request->date .' '.date('H:i:s',strtotime($request->time)),
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


    public function update($request , $id)
    {
        DB::beginTransaction();

        $preview = $this->findById($id);

        try {

            if ($request['preview_status_id']) {

                $preview->update([
                    'note_from_admin'   => $request['note_from_admin'],
                    'preview_status_id' => $request['preview_status_id'],
                    'time'              => $request->date .' '.date('H:i:s',strtotime($request->time)),
                ]);

                $date = $this->modelDate->where('preview_id',$preview['id'])->first();

                $date->update([
                    'date' => $request['date'].' '.date('H:i:s',strtotime($request->time)),
                ]);

                if($request['user_notifi'] == "1")
                    $this->sendNotifiToUser($preview);
            }


            if (is_array_empty($request['technical'])) {

                foreach ($request['service_id'] as $key => $serviceId) {

                    $technicals = $this->modelTech
                                        ->where('service_id',$serviceId)
                                        ->where('preview_id',$request['preview_id'])
                                        ->first();
                    if ($technicals) {
                        $technicals->delete();
                    }

                    $tech = $this->modelTech->create([
                        'preview_id'   => $request['preview_id'],
                        'service_id'   => $serviceId,
                        'user_id'      => $request['technical'][$key],
                        'province_id'  => $request['province_id'],
                        'date'         => $request['date'].' '.date('H:i:s',strtotime($request->time)),
                    ]);

                }

                if($request['tech_notifi'] == "1")
                    $this->sendNotifiToTech($tech);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }


    public function sendNotifiToUser($preview)
    {
        $userToken = $preview->user->deviceToken;

        if (!empty($userToken)) {
            $data = [
                'title' => 'حالة الطلب الخاص بك',
                'body'  => 'تم تغير حالة الطلب الى: '.$preview->previewStatus->name_ar.'',
                'type'  => 'previews',
                'id'    => $preview->id,
            ];

            return $this->send($data,$userToken->device_token);
        }
    }

    public function sendNotifiToTech($tech)
    {
        $userToken = $tech->user->deviceToken;

        if (!empty($userToken)) {

            $data = [
                'title' => 'New Preview',
                'body'  => 'You Have new preview request',
                'type'  => 'previews',
                'id'    => $tech->preview_id,
            ];

            return $this->send($data,$userToken->device_token);
        }
    }

    public function delete($id)
    {
        $preview = $this->findById($id);
        return $preview->delete();
    }


    public function dataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->filter($request,$search);

        $output['recordsTotal']    = $query->count();
        $output['recordsFiltered'] = $query->count();
        $output['draw']            = intval($request->input('draw'));

        // Get Data
        $previews = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($previews))
        {
            foreach ($previews as $preview)
            {
                $id = $preview['id'];

                $show = btn('show','show_previews' , url(route('previews.show',$id)));

                $obj['id']               = $id;
                $obj['time']             = $preview->time;
                $obj['seen']             = $preview->seen ? 'تم المشاهدة من قبل الفني' : '';
                $obj['details']          = $preview->details;
                $obj['preview_status_id']= PreviewStatus($preview);
                $obj['user_id']          = $preview->user->name;
                $obj['subscription']     = Subscribe($preview->user);
                // $obj['subscription']     = $preview->user->checkSubscription ? 'مشترك' : 'غير مشترك';
                $obj['address']          = $preview->address->addressProvince->name_ar;
                $obj['created_at']       = date("d-m-Y H:i:s", strtotime($preview->created_at));
                $obj['listBox']          = checkBoxDelete($id);
                $obj['options']          = $show;

                $data[] = $obj;
            }
        }

        $output['data']  = $data;

        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->model
                ->with('details.service')
                ->where(function($query) use($search) {
                    $query->where('id'          , 'like' , '%'. $search .'%')
                          ->orWhere('time'      , 'like' , '%'. $search .'%')
                          ->orWhere('note'      , 'like' , '%'. $search .'%');
                });

        if ($request['req']['technical_id'] != '') {
            $query->whereHas('technical', function($query) use($request) {
                $query->where('user_id'   , $request['req']['technical_id']);
            });
        }

        if($request['status_id'] == 'no'){
          $query->where('preview_status_id','!=',5)->where('preview_status_id','!=',6);
        }elseif ($request['status_id'] != null) {
          $query->where('preview_status_id',$request['status_id']);
        }

        if ($request['user_id'] != '') {
            $query->where('user_id',$request['user_id']);
        }

        if ($request['req']['service'] != '') {

            $query->whereHas('details', function($query) use($request) {
                $query->where('service_id'   , $request['req']['service']);
            });

        }

        if ($request['req']['governorate'] != '') {

            $query->whereHas('address.addressProvince', function($query) use($request) {
                $query->where('governorate_id'   , $request['req']['governorate']);
            });

        }

        if (isset($request['req']['province']) && $request['req']['province'] != '') {

            $query->whereHas('address', function($query) use($request) {
                $query->where('province_id'   , $request['req']['province']);
            });

        }

        if ($request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);


        return $query;
    }

}

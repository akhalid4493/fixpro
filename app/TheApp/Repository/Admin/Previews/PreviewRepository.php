<?php
namespace App\TheApp\Repository\Admin\Previews;

use App\TheApp\Libraries\ImgRepository;
use App\Models\TechnicalPreview;
use App\Models\PreviewStatus;
use App\Models\PreviewDate;
use App\Models\Preview;
use SendNotifi;
use Auth;
use DB;

class PreviewRepository
{
    use SendNotifi;

    function __construct(
        Preview $preview,
        PreviewStatus $status,
        TechnicalPreview $tech,
        PreviewDate $date
    )
    {
        $this->model        = $preview;
        $this->modelStatus  = $status;
        $this->modelTech    = $tech;
        $this->modelDate    = $date;
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

    public function update($request , $id)
    {
        DB::beginTransaction();

        $preview = $this->findById($id);

        try {

            if ($request['preview_status_id']) {

                $preview->update([
                    'preview_status_id' => $request['preview_status_id'],
                    'time'              => $request['date'].' '.date('H:i:s',strtotime($request->time)),
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
                $obj['details']          = $preview->details;
                $obj['preview_status_id']= PreviewStatus($preview);
                $obj['user_id']          = $preview->user->name;
                $obj['subscription']     = $preview->user->checkSubscription ? 'مشترك' : 'غير مشترك';
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

        if ($request['status_id'] != null) {
          $query->where('preview_status_id',5);
        }else{
          $query->where('preview_status_id','!=',5);
        }
        if ($request['user_id']) {
            $query->where('user_id',$request['user_id']);
        }

        if ($request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);


        return $query;
    }

}

<?php
namespace App\TheApp\Repository\Admin\Previews;

use App\TheApp\Libraries\ImgRepository;
use App\Models\TechnicalPreview;
use App\Models\PreviewStatus;
use App\Models\Preview;
use SendNotifi;
use Auth;
use DB;

class PreviewRepository
{
    protected $model;

    function __construct(Preview $preview,PreviewStatus $status,TechnicalPreview $tech)
    {
        $this->model        = $preview;
        $this->modelStatus  = $status;
        $this->modelTech    = $tech;
    }

    public function countNewPreviews()
    {
        return $this->model->where('preview_status_id', 1)->count();
    }

    public function countDone()
    {
        return $this->model->where('preview_status_id',3)->count();
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
                    'preview_status_id'      => $request['preview_status_id'],
                ]);
    
                if($request['user_notifi'] == "1")
                    $this->sendNotifiToUser($preview);
            }
                

            if ($request['techincal_user_id']) {
                $tech = $this->modelTech->updateOrCreate([
                    'preview_id'   => $id,
                ],
                [
                    'preview_id'            => $id,
                    'user_id'               => $request['techincal_user_id'],
                ]);

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
                'body'  => 'تم تغير حالة الطلب الى: '.$preview->previewStatus->name_ar.''
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
                'body'  => 'You Have new preview request'
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
        $query = $this->model
                        ->where(function($query) use($search) {
                            $query
                            // SEARCH IN previews TABLE
                            ->where('time'       , 'like' , '%'. $search .'%')
                            ->orWhere('note'     , 'like' , '%'. $search .'%')
                            ->orWhere('id'       , 'like' , '%'. $search .'%');
                        });


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

                $nestedData['id']               = $preview->id;
                $nestedData['time']             = $preview->time;
                $nestedData['note']             = $preview->note;
                $nestedData['preview_status_id']= PreviewStatus($preview);
                $nestedData['full_name']        = $preview->user->name;
                $nestedData['email']            = $preview->user->email;
                $nestedData['mobile']           = $preview->user->mobile;
                $nestedData['options']          = $show;
                $nestedData['created_at']       = date("d-m-Y", strtotime($preview->created_at));
                $nestedData['listBox']          = checkBoxDelete($id);
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

}
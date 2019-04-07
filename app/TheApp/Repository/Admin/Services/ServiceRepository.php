<?php
namespace App\TheApp\Repository\Admin\Services;

use App\Models\Service;
use ImageTrait;
use Auth;
use DB;

class ServiceRepository
{
    protected $model;

    function __construct(Service $service)
    {
        $this->model = $service;
    }  

    public function count()
    {
        return $this->model->count();
    }
    
    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();

        if ($request->hasFile('image'))
            $img = ImageTrait::uploadImage($request->image,'services/'.ar_slug($request->name_en));
        else
            $img = ImageTrait::copyImage('default.png','services/'.ar_slug($request->name_en),'default.png');

        try {
            
            $service = $this->model->create([
                    'name_ar'               => $request['name_ar'],
                    'name_en'               => $request['name_en'],
                    'slug'                  => ar_slug($request['name_en']),
                    'status'                => $request['status'],
                    'image'                 => $img,
                ]);

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

        $service = $this->findById($id);

        if ($request->hasFile('image'))
            $img=ImageTrait::uploadImage($request->image,'services/'.ar_slug($request->name_en),$service->image);
        else
            $img  = $service->image;

        try {
            
            $service->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                'slug'                  => ar_slug($request['name_en']),
                'status'                => $request['status'],
                'image'                 => $img,
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }


    public function delete($id)
    {
        DB::beginTransaction();
        
        try {
            
            $service = $this->findById($id);

            ImageTrait::deleteDirectory('uploads/services/'.ar_slug($service->name_en));

            $service->delete();

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteAll($request)
    {
        DB::beginTransaction();
        
        try {
            
            $services = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($services as $service) {
                $service->delete();
            }


            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
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
        $services = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($services))
        {
            foreach ($services as $service)
            {
                $id = $service['id'];

                $edit   = btn('edit'  ,'edit_services'  ,url(route('services.edit',$id)));
                $delete = btn('delete','delete_services',url(route('services.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $service->name_ar;
                $obj['name_en']     = $service->name_en;
                $obj['image']       = url($service->image);
                $obj['status']      = Status($service->status);
                $obj['created_at']  = date("d-m-Y", strtotime($service->created_at));
                $obj['listBox']     = checkBoxDelete($id);
                $obj['options']     = $edit . $delete;;
                
                $data[] = $obj;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->model->where(function($query) use($search) {
                    $query->where('id'         , 'like' , '%'. $search .'%')
                          ->orWhere('name_en'  , 'like' , '%'. $search .'%')
                          ->orWhere('name_ar'  , 'like' , '%'. $search .'%');
                });
    
        if ($request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if ($request['req']['active'] != '')
            $query->where('status' , $request['req']['active']);

        return $query;
    }
}
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

    public function dataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->model
                        ->where(function($query) use($search) {
                            $query
                            // SEARCH IN service TABLE
                            ->where('name_en' 	  , 'like' , '%'. $search .'%')
                            ->orWhere('name_ar'   , 'like' , '%'. $search .'%')
                            ->orWhere('id'        , 'like' , '%'. $search .'%');
                        });


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

                $edit = btn('edit'  ,'edit_services'  ,url(route('services.edit',$id)));
                $dlt  = btn('delete','delete_services',url(route('services.show',$id)));

                $nestedData['id']          = $service->id;
                $nestedData['image']       = url($service->image);
                $nestedData['name_ar']     = $service->name_ar;
                $nestedData['status']      = Status($service->status);
                $nestedData['created_at']  = transDate(date("d M-Y", strtotime($service->created_at)));
                $nestedData['options']     = $edit . $dlt;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }
}
<?php
namespace App\TheApp\Repository\Admin\Governorates;

use App\Models\Governorate;
use DB;

class GovernorateRepository
{
    protected $model;

    function __construct(Governorate $governorate)
    {
        $this->model = $governorate;
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

        try {
            
            $governorate = $this->model->create([
                    'name_en'      => $request['name_en'],
                    'name_ar'      => $request['name_ar'],
                    'status'       => $request['status'],
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

        $governorate = $this->findById($id);

        try {
            
            $governorate->update([
                'name_en'      => $request['name_en'],
                'name_ar'      => $request['name_ar'],
                'status'       => $request['status'],
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
            
            $governorate = $this->findById($id);

            $governorate->delete();

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
            
            $governorates = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($governorates as $governorate) {
                $governorate->delete();
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
        $governorates = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($governorates))
        {
            foreach ($governorates as $governorate)
            {
                $id = $governorate['id'];

                $edit   = btn('edit'  ,'edit_governorates'  ,url(route('governorates.edit',$id)));
                $delete = btn('delete','delete_governorates',url(route('governorates.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $governorate->name_ar;
                $obj['name_en']     = $governorate->name_en;
                $obj['status']      = Status($governorate->status);
                $obj['created_at']  = date("d-m-Y", strtotime($governorate->created_at));
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
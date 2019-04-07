<?php
namespace App\TheApp\Repository\Admin\Provinces;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Province;
use Auth;
use DB;

class ProvinceRepository
{
    protected $model;

    function __construct(Province $province)
    {
        $this->model = $province;
    }  

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function getByGovernorates($governorateId)
    {
        return $this->model->where('governorate_id',$governorateId)->get();
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            
            $province = $this->model->create([
                    'name_en'      => $request['name_en'],
                    'name_ar'      => $request['name_ar'],
                    'status'       => $request['status'],
                    'governorate_id'=> $request['governorate_id'],
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

        $province = $this->findById($id);

        try {
            
            $province->update([
                'name_en'      => $request['name_en'],
                'name_ar'      => $request['name_ar'],
                'status'       => $request['status'],
                'status'       => $request['status'],
                'governorate_id'=> $request['governorate_id'],
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
        $province = $this->findById($id);
        return $province->delete();
    }

    public function deleteAll($request)
    {
        DB::beginTransaction();
        
        try {
            
            $provinces = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($provinces as $province) {
                $province->delete();
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
        $provinces = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($provinces))
        {
            foreach ($provinces as $province)
            {
                $id = $province['id'];

                $edit   = btn('edit'  ,'edit_provinces'  ,url(route('provinces.edit',$id)));
                $delete = btn('delete','delete_provinces',url(route('provinces.show',$id)));

                $obj['id']                  = $id;
                $obj['name_ar']             = $province->name_ar;
                $obj['name_en']             = $province->name_en;
                $obj['governorate_id']      = $province->governorate->name_ar;
                $obj['status']              = Status($province->status);
                $obj['created_at']          = date("d-m-Y", strtotime($province->created_at));
                $obj['listBox']             = checkBoxDelete($id);
                $obj['options']             = $edit . $delete;;
                
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
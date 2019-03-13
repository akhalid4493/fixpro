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

    public function dataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->model
                        ->where(function($query) use($search) {
                            $query
                            // SEARCH IN province TABLE
                            ->where('name_en' 	  , 'like' , '%'. $search .'%')
                            ->orWhere('name_ar'   , 'like' , '%'. $search .'%')
                            ->orWhere('id'        , 'like' , '%'. $search .'%');
                        });


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

                $edit = btn('edit'  ,'edit_provinces'  ,url(route('provinces.edit',$id)));
                $dlt  = btn('delete','delete_provinces',url(route('provinces.show',$id)));

                $nestedData['id']          = $province->id;
                $nestedData['name_en']     = $province->name_en;
                $nestedData['name_ar']     = $province->name_ar;
                $nestedData['status']      = Status($province->status);
                $nestedData['created_at']  = transDate(date("d M-Y", strtotime($province->created_at)));
                $nestedData['options']     = $edit . $dlt;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

}
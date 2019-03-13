<?php
namespace App\TheApp\Repository\Admin\Governorates;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Governorate;
use Auth;
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
        $governorate = $this->findById($id);
        return $governorate->delete();
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
                            // SEARCH IN governorate TABLE
                            ->where('name_en' 	  , 'like' , '%'. $search .'%')
                            ->orWhere('name_ar'   , 'like' , '%'. $search .'%')
                            ->orWhere('id'        , 'like' , '%'. $search .'%');
                        });


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

                $edit = btn('edit'  ,'edit_governorates'  ,url(route('governorates.edit',$id)));
                $dlt  = btn('delete','delete_governorates',url(route('governorates.show',$id)));

                $nestedData['id']          = $governorate->id;
                $nestedData['name_en']     = $governorate->name_en;
                $nestedData['name_ar']     = $governorate->name_ar;
                $nestedData['status']      = Status($governorate->status);
                $nestedData['created_at']  = transDate(date("d M-Y", strtotime($governorate->created_at)));
                $nestedData['options']     = $edit . $dlt;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

}
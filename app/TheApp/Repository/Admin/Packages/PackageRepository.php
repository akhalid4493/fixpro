<?php
namespace App\TheApp\Repository\Admin\Packages;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Package;
use Auth;
use DB;

class PackageRepository
{
    protected $model;

    function __construct(Package $package)
    {
        $this->model = $package;
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
        
        try {
            
            $package = $this->model->create([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                //'price'                 => $request['price'],
                //'months'                => $request['months'],
                'description_ar'        => $request['description_ar'],
                'description_en'        => $request['description_en'],
                'status'                => $request['status'],
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

        $package = $this->findById($id);

        try {
            
            $package->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                //'price'                 => $request['price'],
                //'months'                => $request['months'],
                'description_ar'        => $request['description_ar'],
                'description_en'        => $request['description_en'],
                'status'                => $request['status'],
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
        $package = $this->findById($id);
        return $package->delete();
    }

    public function deleteAll($request)
    {
        DB::beginTransaction();
        
        try {
            
            $packages = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($packages as $package) {
                $package->delete();
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
        $packages = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($packages))
        {
            foreach ($packages as $package)
            {
                $id = $package['id'];

                $edit   = btn('edit'  ,'edit_packages'  ,url(route('packages.edit',$id)));
                $delete = btn('delete','delete_packages',url(route('packages.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $package->name_ar;
                $obj['months']      = $package->months;
                $obj['price']       = Price($package->price);
                $obj['status']      = Status($package->status);
                $obj['created_at']  = date("d-m-Y", strtotime($package->created_at));
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
                    $query->where('id'                 , 'like' , '%'. $search .'%')
                           ->orWhere('name_en'         , 'like' , '%'. $search .'%')
                           ->orWhere('name_en'         , 'like' , '%'. $search .'%')
                           ->orWhere('months'          , 'like' , '%'. $search .'%')
                           ->orWhere('price'           , 'like' , '%'. $search .'%')
                           ->orWhere('description_en'  , 'like' , '%'. $search .'%')
                           ->orWhere('description_ar'  , 'like' , '%'. $search .'%');
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
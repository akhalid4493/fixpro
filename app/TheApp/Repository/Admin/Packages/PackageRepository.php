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
                    'months'                => $request['months'],
                    'description_ar'        => $request['description_ar'],
                    'description_en'        => $request['description_en'],
                    'status'                => $request['status'],
                    'price'                 => $request['price'],
                    'user_id'               => $request['user_id'],
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
                'months'                => $request['months'],
                'description_ar'        => $request['description_ar'],
                'description_en'        => $request['description_en'],
                'status'                => $request['status'],
                'price'                 => $request['price'],
                'user_id'               => $request['user_id'],
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

    public function dataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->model
                        ->where(function($query) use($search) {
                            $query
                            // SEARCH IN package TABLE
                            ->where('name_en' 	  , 'like' , '%'. $search .'%')
                            ->orWhere('name_ar'   , 'like' , '%'. $search .'%')
                            ->orWhere('id'        , 'like' , '%'. $search .'%');
                        });


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

                $edit = btn('edit'  ,'edit_packages'  ,url(route('packages.edit',$id)));
                $dlt  = btn('delete','delete_packages',url(route('packages.show',$id)));

                $nestedData['id']          = $package->id;
                $nestedData['name_ar']     = $package->name_ar;
                $nestedData['months']      = $package->months;
                $nestedData['user_id']     = $package->user->name;
                $nestedData['status']      = Status($package->status);
                $nestedData['price']       = Price($package->price) . ' KWD';
                $nestedData['created_at']  = transDate(date("d M-Y", strtotime($package->created_at)));
                $nestedData['options']     = $edit . $dlt;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }
}
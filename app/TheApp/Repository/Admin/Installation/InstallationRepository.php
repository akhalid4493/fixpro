<?php
namespace App\TheApp\Repository\Admin\Installation;

use App\Models\Installation;
use ImageTrait;
use Auth;
use DB;

class InstallationRepository
{
    protected $model;

    function __construct(Installation $installation)
    {
        $this->model = $installation;
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
            $img = ImageTrait::uploadImage($request->image,'installations/'.ar_slug($request->name_en));
        else
            $img=ImageTrait::copyImage('default.png','installations/'.ar_slug($request->name_en),'default.png');

        try {
            
            $installation = $this->model->create([
                    'name_ar'               => $request['name_ar'],
                    'name_en'               => $request['name_en'],
                    'slug'                  => ar_slug($request['name_en']),
                    'status'                => $request['status'],
                    'price'                 => $request['price'],
                    'description_ar'        => $request['description_ar'],
                    'description_en'        => $request['description_en'],
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

        $installation = $this->findById($id);

        if ($request->hasFile('image'))
            $img=ImageTrait::uploadImage($request->image,'installations/'.ar_slug($request->name_en),$installation->image);
        else
            $img  = $installation->image;

        try {
            
            $installation->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                'slug'                  => ar_slug($request['name_en']),
                'status'                => $request['status'],
                'price'                 => $request['price'],
                'description_ar'        => $request['description_ar'],
                'description_en'        => $request['description_en'],
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
            
            $installation = $this->findById($id);

            ImageTrait::deleteDirectory('uploads/installations/'.ar_slug($installation->name_en));

            $installation->delete();

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
                            // SEARCH IN installation TABLE
                            ->where('name_en' 	  , 'like' , '%'. $search .'%')
                            ->orWhere('name_ar'   , 'like' , '%'. $search .'%')
                            ->orWhere('id'        , 'like' , '%'. $search .'%');
                        });


        $output['recordsTotal']    = $query->count();
        $output['recordsFiltered'] = $query->count();
        $output['draw']            = intval($request->input('draw'));

        // Get Data
        $installations = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();
        if(!empty($installations))
        {
            foreach ($installations as $installation)
            {
                $id = $installation['id'];

                $edit = btn('edit'  ,'edit_installations'  ,url(route('installations.edit',$id)));
                $dlt  = btn('delete','delete_installations',url(route('installations.show',$id)));

                $nestedData['id']          = $installation->id;
                $nestedData['image']       = url($installation->image);
                $nestedData['name_ar']     = $installation->name_ar;
                $nestedData['price']       = Price($installation->price).' KD';
                $nestedData['status']      = Status($installation->status);
                $nestedData['created_at']  = transDate(date("Y-m-d", strtotime($installation->created_at)));
                $nestedData['options']     = $edit . $dlt;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }
}
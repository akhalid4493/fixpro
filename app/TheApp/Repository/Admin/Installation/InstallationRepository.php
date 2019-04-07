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

    public function deleteAll($request)
    {
        DB::beginTransaction();
        
        try {
            
            $installations = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($installations as $installation) {
                $installation->delete();
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

                $edit   = btn('edit'  ,'edit_installations'  ,url(route('installations.edit',$id)));
                $delete = btn('delete','delete_installations',url(route('installations.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $installation->name_ar;
                $obj['price']       = Price($installation->price);
                $obj['image']       = url($installation->image);
                $obj['status']      = Status($installation->status);
                $obj['created_at']  = date("d-m-Y", strtotime($installation->created_at));
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
                          ->orWhere('name_ar'  , 'like' , '%'. $search .'%')
                          ->orWhere('name_en'  , 'like' , '%'. $search .'%')
                          ->orWhere('price'    , 'like' , '%'. $search .'%');
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
<?php
namespace App\TheApp\Repository\Admin\Categories;

use App\Models\Category;
use ImageTrait;
use Auth;
use DB;

class CategoryRepository
{
    protected $model;

    function __construct(Category $category)
    {
        $this->model        = $category;
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
            $img = ImageTrait::uploadImage($request->image,'categories/'.ar_slug($request->name_en));
        else
            $img = ImageTrait::copyImage('default.png','categories/'.ar_slug($request->name_en),'default.png');

        try {
            
            $category = $this->model->create([
                    'name_ar'               => $request['name_ar'],
                    'name_en'               => $request['name_en'],
                    'slug'                  => ar_slug($request['name_en']),
                    'status'                => $request['status'],
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

        $category = $this->findById($id);

        if ($request->hasFile('image'))
            $img=ImageTrait::uploadImage($request->image,'categories/'.ar_slug($request->name_en),$category->image);
        else
            $img  = $category->image;

        try {
            
            $category->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                'slug'                  => ar_slug($request['name_en']),
                'status'                => $request['status'],
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
            
            $category = $this->findById($id);

            ImageTrait::deleteDirectory('uploads/categories/'.ar_slug($category->name_en));

            $category->delete();

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
            
            $categories = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($categories as $category) {
                $category->delete();
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
        $categories = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($categories))
        {
            foreach ($categories as $category)
            {
                $id = $category['id'];

                $edit   = btn('edit'  ,'edit_categories'  ,url(route('categories.edit',$id)));
                $delete = btn('delete','delete_categories',url(route('categories.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $category->name_ar;
                $obj['image']       = url($category->image);
                $obj['status']      = Status($category->status);
                $obj['created_at']  = date("d-m-Y", strtotime($category->created_at));
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
                          ->orWhere('name_en'  , 'like' , '%'. $search .'%');
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
<?php
namespace App\TheApp\Repository\Admin\Pages;

use Illuminate\Http\Request;
use App\Models\Page;
use Auth;
use DB;

class PageRepository
{
    protected $model;

    function __construct(Page $page)
    {
        $this->model = $page;
    }  

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    public function main($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->where('page_id',null)->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            
            $page = $this->model->create([
                    'name_ar'               => $request['name_ar'],
                    'name_en'               => $request['name_en'],
                    'slug'                  => ar_slug($request['name_en']),
                    'status'                => $request['status'],
                    'description_ar'        => $request['description_ar'],
                    'description_en'        => $request['description_en'],
                    'seo_keywords_ar'       => $request['seo_keywords_ar'],
                    'seo_keywords_en'       => $request['seo_keywords_en'],
                    'seo_description_ar'    => $request['seo_description_ar'],
                    'seo_description_en'    => $request['seo_description_en'],
                    'page_id'               => $request['page_id'],
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

        $page = $this->findById($id);

        try {
            
            $page->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                'slug'                  => ar_slug($request['name_en']),
                'status'                => $request['status'],
                'description_ar'        => $request['description_ar'],
                'description_en'        => $request['description_en'],
                'seo_keywords_ar'       => $request['seo_keywords_ar'],
                'seo_keywords_en'       => $request['seo_keywords_en'],
                'seo_description_ar'    => $request['seo_description_ar'],
                'seo_description_en'    => $request['seo_description_en'],
                'page_id'               => $request['page_id'],
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
        $page = $this->findById($id);
        return $page->delete();
    }

    public function deleteAll($request)
    {
        DB::beginTransaction();
        
        try {
            
            $pages = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($pages as $page) {
                $page->delete();
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
        $pages = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($pages))
        {
            foreach ($pages as $page)
            {
                $id = $page['id'];

                $edit   = btn('edit'  ,'edit_pages'  ,url(route('pages.edit',$id)));
                $delete = btn('delete','delete_pages',url(route('pages.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $page->name_ar;
                $obj['name_en']     = $page->name_en;
                $obj['status']      = Status($page->status);
                $obj['created_at']  = date("d-m-Y", strtotime($page->created_at));
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
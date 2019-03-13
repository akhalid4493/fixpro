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

    public function dataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->model
                        ->where(function($query) use($search) {
                            $query
                            // SEARCH IN PAGE TABLE
                            ->where('name_en' 	        , 'like' , '%'. $search .'%')
                            ->orWhere('name_en'         , 'like' , '%'. $search .'%')
                            ->orWhere('description_en'  , 'like' , '%'. $search .'%')
                            ->orWhere('description_ar'  , 'like' , '%'. $search .'%')
                            ->orWhere('id'              , 'like' , '%'. $search .'%');
                        });


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
                $showBtn   = btn('show','show_pages'  ,url(route('pages.show',$page->id)));
                $editBtn   = btn('edit','edit_pages'  ,url(route('pages.edit',$page->id)));
                $deleteBtn = btn('delete','delete_pages',url(route('pages.show',$page->id)));

                $nestedData['id']        = $page->id;
                $nestedData['name_ar']   = $page->name_ar;
                $nestedData['status']    = Status($page->status);
                $nestedData['page_id']   = $page->parent ? '-> '.$page->parent->name_ar : 'صفحة رئيسية';
                $nestedData['created_at']= transDate(date("d-m-Y", strtotime($page->created_at)));
                $nestedData['options']   = $editBtn . $deleteBtn;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

}
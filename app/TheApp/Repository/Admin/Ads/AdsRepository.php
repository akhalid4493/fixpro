<?php
namespace App\TheApp\Repository\Admin\Ads;

use App\Models\Ads;
use ImageTrait;
use Auth;
use DB;

class AdsRepository
{
    protected $model;

    function __construct(Ads $ads)
    {
        $this->model        = $ads;
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
            $img = ImageTrait::uploadImage($request->image,'ads/'.ar_slug($request->name_en));
        else
            $img = ImageTrait::copyImage('default.png','ads/'.ar_slug($request->name_en),'default.png');

        try {

            $ads = $this->model->create([
                    'name_ar'               => $request['name_ar'],
                    'name_en'               => $request['name_en'],
                    'status'                => $request['status'],
                    'link'                  => $request['link'],
                    'start_at'              => $request['start_at'],
                    'end_at'                => $request['end_at'],
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

        $ads = $this->findById($id);

        if ($request->hasFile('image'))
            $img=ImageTrait::uploadImage($request->image,'ads/'.ar_slug($request->name_en),$ads->image);
        else
            $img  = $ads->image;

        try {

            $ads->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                'status'                => $request['status'],
                'link'                  => $request['link'],
                'start_at'              => $request['start_at'],
                'end_at'                => $request['end_at'],
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

            $ads = $this->findById($id);

            ImageTrait::deleteDirectory('uploads/ads/'.ar_slug($ads->name_en));

            $ads->delete();

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

            $ads = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($ads as $ads) {
                $ads->delete();
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
        $ads = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($ads))
        {
            foreach ($ads as $ads)
            {
                $id = $ads['id'];

                $edit   = btn('edit'  ,'edit_ads'  ,url(route('ads.edit',$id)));
                $delete = btn('delete','delete_ads',url(route('ads.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $ads->name_ar;
                $obj['image']       = url($ads->image);
                $obj['status']      = Status($ads->status);
                $obj['created_at']  = date("d-m-Y", strtotime($ads->created_at));
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

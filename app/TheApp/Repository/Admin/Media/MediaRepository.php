<?php
namespace App\TheApp\Repository\Admin\Media;

use ImageTrait;
use Illuminate\Http\Request;
use App\Models\Media;
use Auth;
use DB;

class MediaRepository
{
    protected $model;

    function __construct(Media $media)
    {
        $this->imagesModel  = $media;
    }

    public function createGallery($request)
    {
        DB::beginTransaction();

        try {
            
            foreach ($request['image'] as $img) {

                $img = ImageTrait::uploadImage($img,'media');


                $adImages = $this->imagesModel->create([
                    'image'  => $img,
                ]);
                
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteGallary($id)
    {
        DB::beginTransaction();
        
        try {
            
            $img = $this->imagesModel->find($id);

            ImageTrait::deleteImagePath($img->image);

            $img->delete();

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
            
            $imgs = $this->imagesModel->whereIn('id',$request['ids'])->get();

            foreach ($imgs as $img) {
                ImageTrait::deleteImagePath($img->image);
                $img->delete();
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
    
    public function gallarydataTable($request)
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
        $images = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($images))
        {
            foreach ($images as $img)
            {
                $id = $img['id'];

                $delete = btn('delete','delete_media',url(route('media.show',$id)));

                $obj['id']          = $id;
                $obj['image']       = url($img->image);
                $obj['created_at']  = date("d-m-Y", strtotime($img->created_at));
                $obj['listBox']     = checkBoxDelete($id);
                $obj['options']     = $delete;
                
                $data[] = $obj;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->imagesModel->where(function($query) use($search) {
                    $query->where('id'         , 'like' , '%'. $search .'%')
                          ->orWhere('image'    , 'like' , '%'. $search .'%');
                });
    
        if ($request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);


        return $query;
    }
}
<?php
namespace App\TheApp\Repository\Admin\Media;

use App\TheApp\Libraries\ImgRepository;
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

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->imagesModel->orderBy($order, $sort)->get();
    }

    public function mainproducts($order = 'id', $sort = 'desc')
    {
        return $this->imagesModel->where('product_id', null)->get();
    }

    public function findById($id)
    {
        return $this->imagesModel->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();
        
        if ($request->hasFile('image'))
            $image = ImgRepository::uploadImage($request['image']);
        else
            $image  = 'uploads/default.png';

        try {
            
            $product = $this->imagesModel->create([
                    'name_ar'               => $request['name_ar'],
                    'name_en'               => $request['name_ar'],
                    'slug'                  => ar_slug($request['slug']),
                    'status'                => $request['status'],
                    'price'                 => $request['price'],
                    'description_ar'        => $request['description_ar'],
                    'description_en'        => $request['description_ar'],
                    'seo_keywords_ar'       => $request['seo_keywords_ar'],
                    'seo_keywords_en'       => $request['seo_keywords_ar'],
                    'seo_description_ar'    => $request['seo_description_ar'],
                    'seo_description_en'    => $request['seo_description_ar'],
                    'image'                 => $image,
                    'category_id'           => $request['category_id'],
                ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function createGallery($request)
    {
        DB::beginTransaction();

        try {
            
            foreach ($request['image'] as $img) {

                $image = ImgRepository::mulitUploads($img);

                $adImages = $this->imagesModel->create([
                    'image'  => $image,
                ]);
                
            }

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

        $product = $this->findById($id);

        if ($request->hasFile('image'))
            $image = ImgRepository::uploadImage($request['image']);
        else
            $image  = $product->image;

        try {
            
            $product->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_ar'],
                'slug'                  => ar_slug($request['slug']),
                'status'                => $request['status'],
                'price'                 => $request['price'],
                'description_ar'        => $request['description_ar'],
                'description_en'        => $request['description_ar'],
                'seo_keywords_ar'       => $request['seo_keywords_ar'],
                'seo_keywords_en'       => $request['seo_keywords_ar'],
                'seo_description_ar'    => $request['seo_description_ar'],
                'seo_description_en'    => $request['seo_description_ar'],
                'image'                 => $image,
                'category_id'           => $request['category_id'],
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
        $product = $this->findById($id);
        return $product->delete();
    }

    public function deleteGallary($id)
    {
        $img = $this->imagesModel->find($id);
        return $img->delete();
    }

    public function dataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->imagesModel
                        ->where(function($query) use($search) {
                            $query
                            // SEARCH IN product TABLE
                            ->where('name_en' 	  , 'like' , '%'. $search .'%')
                            ->orWhere('name_ar'   , 'like' , '%'. $search .'%')
                            ->orWhere('id'        , 'like' , '%'. $search .'%');
                        });


        $output['recordsTotal']    = $query->count();
        $output['recordsFiltered'] = $query->count();
        $output['draw']            = intval($request->input('draw'));

        // Get Data
        $products = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();
        if(!empty($products))
        {
            foreach ($products as $product)
            {
                $id = $product['id'];

                $img  = btn('gallery','edit_products',url(route('media.show',$id)),$product->gallery);
                $edit = btn('edit'  ,'edit_products'  ,url(route('products.edit',$id)));
                $dlt  = btn('delete','delete_products',url(route('products.show',$id)));

                $nestedData['id']          = $product->id;
                $nestedData['image']       = url($product->image);
                $nestedData['name_ar']     = $product->name_ar;
                $nestedData['status']      = Status($product->status);
                $nestedData['created_at']  = transDate(date("d M-Y", strtotime($product->created_at)));
                $nestedData['options']     = $img  . $edit . $dlt;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

    public function gallarydataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->imagesModel;


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
                $id = $img->id;

                $delete = btn( 'delete','delete_media',url(route('media.show',$id)) );

                $nestedData['id']         = $img->id;
                $nestedData['image']      = url($img->image);
                $nestedData['options']    = $delete;
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }
}
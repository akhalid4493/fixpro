<?php
namespace App\TheApp\Repository\Admin\Product;

use App\Models\Product;
use ImageTrait;
use Auth;
use DB;

class ProductRepository
{
    protected $model;

    function __construct(Product $product)
    {
        $this->model        = $product;
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
            $img = ImageTrait::uploadImage($request->image,'products/'.ar_slug($request->name_en));
        else
            $img = ImageTrait::copyImage('default.png','products/'.ar_slug($request->name_en),'default.png');

        try {
            
            $product = $this->model->create([
                    'name_ar'               => $request['name_ar'],
                    'name_en'               => $request['name_en'],
                    'slug'                  => ar_slug($request['name_en']),
                    'status'                => $request['status'],
                    'price'                 => $request['price'],
                    'warranty'              => $request['warranty'],
                    'description_ar'        => $request['description_ar'],
                    'description_en'        => $request['description_en'],
                    'image'                 => $img,
                ]);
            
            $product->categories()->sync($request['categories']);

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
            $img=ImageTrait::uploadImage($request->image,'products/'.ar_slug($request->name_en),$product->image);
        else
            $img  = $product->image;

        try {
            
            $product->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                'warranty'              => $request['warranty'],
                'slug'                  => ar_slug($request['name_en']),
                'status'                => $request['status'],
                'price'                 => $request['price'],
                'description_ar'        => $request['description_ar'],
                'description_en'        => $request['description_en'],
                'image'                 => $img,
            ]);

            $product->categories()->sync($request['categories']);

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
            
            $product = $this->findById($id);

            ImageTrait::deleteDirectory('uploads/products/'.ar_slug($product->name_en));

            $product->delete();

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
            
            $products = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($products as $product) {
                $product->delete();
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

                $edit   = btn('edit'  ,'edit_products'  ,url(route('products.edit',$id)));
                $delete = btn('delete','delete_products',url(route('products.show',$id)));

                $obj['id']          = $id;
                $obj['name_ar']     = $product->name_ar;
                $obj['warranty']    = $product->warranty;
                $obj['price']       = Price($product->price);
                $obj['image']       = url($product->image);
                $obj['status']      = Status($product->status);
                $obj['created_at']  = date("d-m-Y", strtotime($product->created_at));
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
                          ->orWhere('warranty' , 'like' , '%'. $search .'%')
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
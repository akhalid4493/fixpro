<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Product\ProductRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use DB;

class ProductController extends AdminController
{

    function __construct(ProductRepository $product)
    {
        $this->productModel  = $product;
    }


    public function index()
    {
        return view('admin.products.home');
    }


    public function dataTable(Request $request)
    {
        return $this->productModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.products.create');
    }


    public function store(Request $request)
    {
        $create = $this->productModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $product = $this->productModel->findById($id);
        
        if (!$product)
            abort(404);

        return view('admin.products.show' , compact('product'));
    }


    public function edit($id)
    {
        $product    = $this->productModel->findById($id);

        if (!$product)
            abort(404);

        return view('admin.products.edit',compact('product'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->productModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->productModel->delete($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

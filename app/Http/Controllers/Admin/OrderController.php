<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Orders\OrderRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use DB;

class OrderController extends AdminController
{

    function __construct(OrderRepository $order)
    {
        $this->orderModel = $order;

        // PERMISSION OF ADMIN FUNCTIONS
        $this->middleware('permission:show_orders'  ,['only' => ['show'   , 'index']]);
        $this->middleware('permission:add_orders'   ,['only' => ['create' , 'store']]);
        $this->middleware('permission:edit_orders'  ,['only' => ['edit'   , 'update']]);
        $this->middleware('permission:delete_orders',['only' => ['destroy']]);
    }


    public function index()
    {
        return view('admin.orders.home');
    }


    public function dataTable(Request $request)
    {
        return $this->orderModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.orders.create');
    }


    public function store(Request $request)
    {
            $create = $this->orderModel->create($request);

            if($create)
                return Response()->json([true , 'تم الاضافة بنجاح' ]);
            
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $order = $this->orderModel->findById($id);
        $statuses   = $this->orderModel->getAllStatus();

        if (!$order)
            abort(404);

        return view('admin.orders.show' , compact('order','statuses'));
    }


    public function edit($id)
    {
        $order   = $this->orderModel->findById($id);

        if (!$order)
            abort(404);

        return view('admin.orders.edit',compact('order'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->orderModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->orderModel->delete($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

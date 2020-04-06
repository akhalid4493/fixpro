<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Users\TechncialRepository as Technical;
use App\TheApp\Repository\Admin\Orders\OrderRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class OrderController extends AdminController
{

    function __construct(OrderRepository $order,Technical $technical)
    {
        $this->orderModel       = $order;
        $this->technicalModel   = $technical;
    }

    // public function updateProfit()
    // {
    //    $order = $this->orderModel->getAll();
    //
    //     $array = [];
    //
    //       foreach ($order as $key => $value) {
    //
    //         $total_profit_product  = 0;
    //         $installation_total    = 0;
    //
    //         foreach ($value->productsOfOrder as $key => $orderProduct) {
    //
    //           $orderProduct->update([
    //             'profit_price' =>  $orderProduct->product->profit_price ,
    //             'profit_total' =>  $orderProduct->product->profit_price * $orderProduct->qty,
    //           ]);
    //
    //           $total_profit_product += $orderProduct['profit_price'] * $orderProduct['qty'];
    //         }
    //
    //         foreach ($value->installationsOfOrder as $key => $installation) {
    //           $installation_total += $installation['price'] * $installation['qty'];
    //         }
    //
    //
    //         $subtotal = $installation_total+$total_profit_product;
    //
    //         $value->update([
    //           'subtotal_profit' => $subtotal,
    //           'total_profit'    => $subtotal + $value->service,
    //         ]);
    //
    //       }
    //
    //     return $array;
    // }

    public function index()
    {
        $technicals = $this->technicalModel->TechnicalUsers();
        return view('admin.orders.home',compact('technicals'));
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

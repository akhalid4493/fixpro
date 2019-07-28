<?php
namespace App\TheApp\Repository\Api\Orders;

use App\TheApp\Repository\Api\Transaction\TransactionRepository;
use App\Http\Resources\Orders\OrderResource;
use App\Models\OrderInstallation;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Installation;
use App\Models\Product;
use ProductsQty;
use SendNotifi;
use Auth;
use DB;

class OrderRepository
{

    use SendNotifi;

    function __construct(Order $order ,OrderProduct $product,OrderInstallation $installation)
    {
        $this->model            = $order;
        $this->modelProduct     = $product;
        $this->modelInstallation= $installation;
    }


    /*
    ===============================================
            USER APP API ORDER METHODS
    ===============================================
    */
    public function myOrders()
    {
        $orders = $this->model->where('user_id',Auth::id())->get();

        return $orders;
    }


    public function orderById($id)
    {
        $order = $this->model->where('id',$id)->where('user_id',Auth::id())->first();

        return $order;
    }

    public function orderAction($order,$request)
    {
        DB::beginTransaction();

        try {

            $order->update([
                'order_status_id'   => $request['status'],
                'method'            => $request['method'],
            ]);


            DB::commit();

            return $order;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function finalStep($data)
    {
        $order = $this->orderById($data['udf1']);

        DB::beginTransaction();

        try {

            $order = $order->update([
                'order_status_id'   => 5,
                'method'            => 'KNET',
            ]);


            DB::commit();

            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /*
    ===============================================
            TECHNICAL APP API ORDER METHODS
    ===============================================
    */

    public function technicalOrders()
    {
        $orders = $this->model->where('technical_id',Auth::id())->get();

        return $orders;
    }


    public function technicalOrderById($id)
    {
        $order = $this->model->where('id',$id)->where('technical_id',Auth::id())->first();

        return $order;
    }

    public function addNewOrder($request)
    {
        $order  = $this->calculateTotal($request);

        return $order;
    }

    public function calculateTotal($request)
    {
        $total_products        = 0;
        $total_profit          = 0;
        $installation_total    = 0;

        if ($request['product_id']) {
            foreach ($request['product_id'] as $key => $product) {
                $item_ = Product::find($product);
                $total_products += $item_['price'] * $request['qty_product'][$key];
                $total_profit += $item_['profit_price'] * $request['qty_product'][$key];
            }
        }

        if ($request['installation_id']) {
            foreach ($request['installation_id'] as $key => $installation) {
                $installation_ = Installation::find($installation);
                $installation_total += $installation_['price'] * $request['qty_installation'][$key];
            }
        }

        $subtotal        = $total_products + $installation_total;
        $subtotal_profit = $total_profit + $installation_total;

        $order = $this->createOrder($request,$subtotal,$subtotal_profit);

        if ($order) {
            return $order;
        }

    }

    public function createOrder($request,$subtotal,$subtotal_profit)
    {
        DB::beginTransaction();

        if ($request['method'] == 'Knet') {
            $status = 4;
        }else{
            $status = 5;
        }

        try {

            $serviceFees = $request['service'] == 'on' ? settings('service') : 0.000;

            $order = $this->model->create([
                'subtotal'          => $subtotal,
                'subtotal_profit'   => $subtotal_profit,
                'service'           => $serviceFees,
                'total'             => $subtotal + $serviceFees,
                'total_profit'      => $subtotal_profit + $serviceFees,
                'method'            => $request['method'],
                'transID'           => $request['transID'],
                'preview_id'        => $request['preview_id'],
                'user_id'           => $request['client_user_id'],
                'order_status_id'   => $status,
                'technical_id'      => Auth::id(),
            ]);

            if ($order)
                $orderDetails = $this->createOrderDetails($order['id'],$request);

            $this->sendNotifiToUser($order);

            DB::commit();
            return $order;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function createOrderDetails($orderId,$request)
    {
        DB::beginTransaction();

        try {

            if ($request['product_id']) {
                foreach ($request['product_id'] as $key => $product) {

                    $item = Product::find($product);

                    $warranty = $this->calculatWarranty($request,$item);

                    $this->modelProduct->create([
                        'warranty'      => $warranty['months'],
                        'warranty_start'=> $warranty['start'],
                        'warranty_end'  => $warranty['end'],
                        'product_id'    => $product,
                        'qty'           => $request['qty_product'][$key],
                        'order_id'      => $orderId,
                        'price'         => $item->price,
                        'profit_price'  => $item->profit_price,
                        'profit_total'  => $item->profit_price * $request['qty_product'][$key],
                        'total'         => $item->price * $request['qty_product'][$key],
                    ]);
                }
            }

            if ($request['installation_id']) {
                foreach ($request['installation_id'] as $key => $installation) {

                    $installation_ = Installation::find($installation);

                    $warranty_inst = $this->calculatWarrantyInstallation();

                    $this->modelInstallation->create([
                        'warranty'          => $warranty_inst['days'],
                        'warranty_start'    => $warranty_inst['start'],
                        'warranty_end'      => $warranty_inst['end'],
                        'installation_id'   => $installation_['id'],
                        'qty'               => $request['qty_installation'][$key],
                        'order_id'          => $orderId,
                        'price'             => $installation_->price,
                        'total'             => $installation_->price*$request['qty_installation'][$key],
                    ]);
                }
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }

    }

    public function calculatWarranty($request,$item)
    {
        $warranty['months'] =  $item['warranty'];

        $warranty['start']  = date('d-m-Y');
        $warranty['end']    = date('d-m-Y', strtotime('+'.$warranty['months'].' months'));

        return $warranty;
    }

    public function calculatWarrantyInstallation()
    {
        $warranty['days']   =  settings('warranty');

        $warranty['start']  = date('d-m-Y');
        $warranty['end']    = date('d-m-Y', strtotime('+'.$warranty['days'].' days'));

        return $warranty;
    }

    public function sendNotifiToUser($order)
    {
        $userToken = $order->user->deviceToken;

        if (!empty($userToken)) {

            $data = [
                'title' => 'لديك طلب جديد',
                'body'  => 'تم ارسال لك طلب جديد خاص  بالمعانية',
                'type'  => 'orders',
                'id'    => $order->id,
            ];

            return $this->send($data,$userToken->device_token);
        }
    }
}

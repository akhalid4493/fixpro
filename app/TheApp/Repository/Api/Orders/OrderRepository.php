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
use Auth;
use DB;

class OrderRepository
{

    protected $model;

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
        $orders = $this->model->where('user_id',Auth::user()->id)->get();

        return $orders;
    }


    public function orderById($id)
    {
        $order = $this->model->find($id);

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
    public function addNewOrder($request)
    {
        $order  = $this->calculateTotal($request);

        return $order;
    }

    public function calculateTotal($request)
    {
        $subtotal  = 0;

        if ($request['product_id']) {
            foreach ($request['product_id'] as $key => $product) {
                $item_ = Product::find($product);
                $subtotal += $item_['price'] * $request['qty_product'][$key];
            }
        }
            
        if ($request['installation_id']) {
            foreach ($request['installation_id'] as $key => $installation) {
                $installation_ = Installation::find($installation);
                $subtotal += $installation_['price'] * $request['qty_installation'][$key];
            }
        }

        $order = $this->createOrder($request,$subtotal);

        if ($order) {
            return $order;
        }

    }

    public function createOrder($request,$subtotal)
    {
        DB::beginTransaction();

        try {
            
            $order = $this->model->create([
                'total'             => $subtotal,
                'method'            => null,
                'preview_id'        => $request['preview_id'],
                'user_id'           => $request['client_user_id'],
                'order_status_id'   => 1,
            ]);

            if ($order)
                $orderDetails = $this->createOrderDetails($order['id'],$request);

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
                    'total'         => $item->price * $request['qty_product'][$key],
                ]);
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
                'title' => 'طلب جديد',
                'body'  => 'تم ارسال لك الطلب الخاص بك'
            ];

            return $this->send($data,$userToken->device_token);
        }
    }
}
<?php
namespace App\TheApp\Repository\Api\Orders;

use App\TheApp\Repository\Api\Transaction\TransactionRepository;
use App\Http\Resources\Orders\OrderResource;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Order;
use ProductsQty;
use Auth;
use DB;

class OrderRepository
{

    protected $model;

    function __construct(Order $order ,OrderProduct $product)
    {
        $this->model        = $order;
        $this->modelProduct = $product;
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
        $subtotal = 0;

        foreach ($request['product_ids'] as $product) {
            $item_ = Product::find($product['product_id']);
            $subtotal += $item_['price'] * $product['qty'];
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

            foreach ($request['product_ids'] as $product) {
                
                $item = Product::find($product['product_id']);
                
                $output = $this->arrayDetails($item,$product,$orderId);

                $this->modelDetails->create($output);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }

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

    public function arrayDetails($item,$product,$orderId)
    {
        $obj = array();

        $array1 = [
            'product_id'=> $product['product_id'],
            'qty'       => $product['qty'],
            'order_id'  => $orderId,
            'price'     => $item->price,
            'total'     => $item->price * $product['qty'],
        ];

         if ($item['warranty']) {
            $array2 = [
                'warranty'                   => $product['warranty'],
                'warranty_start'             => $product['warranty_start'],
                'warranty_end'               => $product['warranty_end'],
                'warranty_installation'      => $product['warranty_installation'],
                'warranty_installation_start'=> $product['warranty_installation_start'],
                'warranty_installation_end'  => $product['warranty_installation_end'],
            ];
        }else{
            $array2 = [];
        }

        
        return $output = array_merge($array1, $array2);;
    }
}
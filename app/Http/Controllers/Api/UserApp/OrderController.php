<?php

namespace App\Http\Controllers\Api\UserApp;

use App\Http\Controllers\Payment\OrderPaymentController as Payment;
use App\TheApp\Repository\Api\Orders\OrderRepository as Order;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class OrderController extends ApiController
{
    public function __construct(Order $order, Payment $payment)
    {
        $this->payment 		 = $payment;
        $this->orderModel    = $order;
    }

    public function myOrders()
    {
        $orders = $this->orderModel->myOrders();

        return $this->responseMessages(OrderResource::collection($orders), true, 200);
    }

    public function getOrder($id)
    {
        $order = $this->orderModel->orderById($id);

        if ($order) {
            return $this->responseMessages(new OrderResource($order), true, 200);
        }

        return $this->responseMessages([], false, 405, [ 'no order with this id']);
    }

    // Make New Order
    public function orderAction(Request $request, $id)
    {
        $order = $this->orderModel->orderById($id);


        $payment = $this->payment->send($order, 'orders', $request['payment']);

        return $this->responseMessages([
            'message' => 'The Payment Url',
            'data'    => $payment,
        ], true, 200);

        // $this->responseMessages(new OrderResource($order), true, 200);
    }

    public function success(Request $request)
    {
        $this->orderModel->updateOrder($request,5);

        $order = $this->orderModel->findById($request['OrderID']);

        return $this->responseMessages(new OrderResource($order), true, 200);
    }

    public function webhooks(Request $request)
    {
        $status = 4;

        if ($request['Result'] == 'CAPTURED') {
            $status = 5;
        }

        $order = $this->order->updateOrder($request, $status);
    }

    public function failed(Request $request)
    {
        $this->orderModel->updateOrder($request,4);

        $order = $this->orderModel->findById($request['OrderID']);

        return $this->responseMessages([], false, 405, [ 'payment failed']);
    }
}

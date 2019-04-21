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
   	function __construct(Order $order,Payment $payment)
    {
        $this->payment 		 = $payment;
        $this->orderModel    = $order;
    }

   	public function myOrders()
	{
		$orders = $this->orderModel->myOrders();

		return $this->responseMessages(OrderResource::collection($orders),true,200);
	}

	public function getOrder($id)
	{
		$order = $this->orderModel->orderById($id);

		if ($order)
			return $this->responseMessages(new OrderResource($order),true,200);

		return $this->responseMessages([],false,405,[ 'no order with this id']);
	}

    // Make New Order
	public function orderAction(Request $request,$id)
	{
		$order = $this->orderModel->orderById($id);

		if ($request['status'] == 2) {
		 	if ($request['method'] == 'KNET') {

				$payment = $this->payment->send($order,$request);

				return response()->json([
		            'message' => 'The Payment Url',
		            'data'    => $payment['paymentURL'],
		        ],200);

			}else{
			 	$changeOrder = $this->orderModel->orderAction($order,$request);
				return $this->responseMessages(new OrderResource($changeOrder),true,200);
			}
		}else{
			$changeOrder = $this->orderModel->orderAction($order,$request);
			return $this->responseMessages(new OrderResource($changeOrder),true,200);
		}

		return $this->responseMessages([],false,405,[ 'please try again ']);
	}
}

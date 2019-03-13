<?php

namespace App\Http\Controllers\Api\TechApp;

use App\TheApp\Repository\Api\Products\ProductRepository as Product;
use App\Http\Controllers\Payment\OrderPaymentController as Payment;
use App\TheApp\Repository\Api\Orders\OrderRepository as Order;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class StoreController extends ApiController
{
   	function __construct(Product $product,Order $order,Payment $payment)
    {
        $this->payment 		 = $payment;
        $this->productModel  = $product;
        $this->orderModel    = $order;

        $this->middleware('apiTechAuth', [
	    	'only' => [ 
	    			'makeOrder',  
    				'myOrders', 
    				'getOrder',
	    		]
		]);
    }

	// GetAll Products
	public function products(Request $request)
	{
		return $data = ProductResource::collection($this->productModel->getAll($request));
	}

	// Get Product By Id
	public function product($id)
	{
		$product = $this->productModel->findById($id);

        if ($product != null)
            return $this->responseMessages(new ProductResource($product),true,200);

        return $this->responseMessages([],false,404,[ 'product not found']);
	}


	/*
 	===============================================
  				ORDER METHODS
    =============================================== 
    */
   
    // Make New Order
	public function makeOrder(Request $request)
	{
	 	$newOrder = $this->orderModel->addNewOrder($request);

	 	if ($newOrder)
            return $this->responseMessages(new OrderResource($newOrder),true,200);

		return $this->responseMessages([],false,405,[ 'please try again ']);
	}


	public function myOrders(Request $request)
	{
		$orders = $this->orderModel->myOrders($request);

		if ($orders->isNotEmpty())
			return $this->responseMessages(OrderResource::collection($orders),true,200);

		return $this->responseMessages([],false,405,[ 'there is no orders for this user']);
	}
	
	public function getOrder(Request $request,$id)
	{
		$order = $this->orderModel->orderById($id);

		if ($order)
			return $this->responseMessages(new OrderResource($order),true,200);

		return $this->responseMessages([],false,405,[ 'no order with this id']);
	}
}

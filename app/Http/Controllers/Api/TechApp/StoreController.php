<?php

namespace App\Http\Controllers\Api\TechApp;

use App\TheApp\Repository\Api\Installations\InstallationRepository as Installation;
use App\TheApp\Repository\Api\Products\ProductRepository as Product;
use App\TheApp\Repository\Api\Orders\OrderRepository as Order;
use App\Http\Resources\Installations\InstallationResource;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class StoreController extends ApiController
{
   	function __construct(Product $product,Installation $installation,Order $order)
    {
        $this->installationModel= $installation;
        $this->productModel  	= $product;
        $this->orderModel    	= $order;
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

	// GetAll Installations
	public function installations(Request $request)
	{
		return $data = InstallationResource::collection($this->installationModel->getAll($request));
	}

	// Get Installation By Id
	public function installation($id)
	{
		$product = $this->installationModel->findById($id);

        if ($product != null)
            return $this->responseMessages(new InstallationResource($product),true,200);

        return $this->responseMessages([],false,404,[ 'installation not found']);
	}

	/*
 	===============================================
  				ORDER METHODS
    =============================================== 
    */
   
    // Make New Order
	public function createOrder(Request $request)
	{
	 	$newOrder = $this->orderModel->addNewOrder($request);

	 	if ($newOrder)
            return $this->responseMessages(new OrderResource($newOrder),true,200);

		return $this->responseMessages([],false,405,[ 'please try again ']);
	}
}

<?php

namespace App\Http\Controllers\Api\TechApp;

use App\TheApp\Repository\Api\Installations\InstallationRepository as Installation;
use App\TheApp\Repository\Api\Categories\CategoryRepository as Category;
use App\TheApp\Repository\Api\Products\ProductRepository as Product;
use App\Http\Controllers\Payment\OrderPaymentController as Payment;
use App\TheApp\Repository\Api\Orders\OrderRepository as Order;
use App\Http\Resources\Installations\InstallationResource;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Orders\OrderResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class StoreController extends ApiController
{
    public function __construct(
        Product $product,
        Installation $installation,
        Order $order,
        Payment $payment,
        Category $category
    ) {
        $this->installationModel= $installation;
        $this->productModel  	= $product;
        $this->categoryModel 	= $category;
        $this->orderModel    	= $order;
        $this->payment 		 	= $payment;
    }

    // GetAll Categories
    public function categories(Request $request)
    {
        return $data = CategoryResource::collection($this->categoryModel->getAllForTechnicalUser($request));
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

        if ($product != null) {
            return $this->responseMessages(new ProductResource($product), true, 200);
        }

        return $this->responseMessages([], false, 404, [ 'product not found']);
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

        if ($product != null) {
            return $this->responseMessages(new InstallationResource($product), true, 200);
        }

        return $this->responseMessages([], false, 404, [ 'installation not found']);
    }

    /*
    ===============================================
                ORDER METHODS
    ===============================================
    */

    public function myOrders(Request $request)
    {
        $orders = $this->orderModel->technicalOrders($request);

        return $this->responseMessages(OrderResource::collection($orders), true, 200);
    }

    public function getOrder(Request $request, $id)
    {
        $order = $this->orderModel->technicalOrderById($id);

        if ($order) {
            return $this->responseMessages(new OrderResource($order), true, 200);
        }

        return $this->responseMessages([], false, 405, ['no order with this id']);
    }

    // Make New Order
    public function createOrder(Request $request)
    {
        $order = $this->orderModel->addNewOrder($request);

        if ($request['method'] != 'cash'){

            return $this->responseMessages(new OrderResource($order), true, 200);

            // $payment = $this->payment->send($order,'orders',$request['payment']);

            // return response()->json([
            //     'message' => 'The Payment Url',
            //     'data'    => $payment,
            // ], 200);
        }

        return $this->responseMessages([], false, 405, ['please try again']);
    }
}

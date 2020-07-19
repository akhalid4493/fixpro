<?php

namespace App\Http\Controllers\Api\V2\UserApp;

use App\TheApp\Repository\Api\V2\Previews\PreviewRepository as Preveiew;
use App\Http\Controllers\Payment\OrderPaymentController as Payment;
use App\TheApp\Repository\Api\V2\Orders\OrderRepository as Order;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Previews\PreviewResource;
use App\Http\Resources\Services\ServiceResource;
use App\Http\Controllers\Api\ApiController;
use App\TheApp\CustomClass\PreviewCheck;
use Illuminate\Http\Request;
use Auth;

class PreviewController extends ApiController
{
    public function __construct(Preveiew $preview, Payment $payment)
    {
        $this->payment 		 = $payment;
        $this->previewModel  = $preview;
    }

    public function checkDates(Request $request)
    {
        $dates = PreviewCheck::getPreviews($request['service_id'], $request['governorate_id']);
        return $this->responseMessages($dates, true, 200);
    }

    public function categories()
    {
        $data = CategoryResource::collection($this->previewModel->getCategories());

        return $this->responseMessages($data, true, 200);
    }

    public function services()
    {
        $data = ServiceResource::collection($this->previewModel->getServices());

        return $this->responseMessages($data, true, 200);
    }

    public function request(Request $request)
    {
        $preview = $this->previewModel->userCreateRequest($request);

        if ($request['method'] == 'knet') {

            $payment = $this->payment->send($preview, 'previews', $request['method']);

            return $this->responseMessages([
                'message' => 'The Payment Url',
                'data'    => $payment,
            ], true, 200);
        }

        return $this->responseMessages(new PreviewResource($preview), true, 200);
    }

    public function myPreviews(Request $request)
    {
        $previews = $this->previewModel->myPreviews($request);

        return $this->responseMessages(PreviewResource::collection($previews), true, 200);
    }

    public function myPreview(Request $request, $id)
    {
        $preview = $this->previewModel->previewById($id);

        if ($preview) {
            return $this->responseMessages(new PreviewResource($preview), true, 200);
        }

        return $this->responseMessages([], false, 405, ['no preview with this id']);
    }

    public function success(Request $request)
    {
        $this->previewModel->updatPreview($request,1);

        $preview = $this->previewModel->findById($request['OrderID']);

        return $this->responseMessages(new PreviewResource($preview), true, 200);
    }

    public function webhooks(Request $request)
    {
        $status = 6;

        if ($request['Result'] == 'CAPTURED') {

            $status = 1;

        }

        $preview = $this->previewModel->updatPreview($request, $status);
    }

    public function failed(Request $request)
    {
        $this->previewModel->updatPreview($request , 6);

        $preview = $this->previewModel->findById($request['OrderID']);

        return $this->responseMessages([], false, 405, [ 'payment failed']);
    }
}

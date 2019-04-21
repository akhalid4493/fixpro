<?php

namespace App\Http\Controllers\Api\UserApp;

use App\TheApp\Repository\Api\Previews\PreviewRepository as Preveiew;
use App\Http\Resources\Previews\PreviewResource;
use App\Http\Resources\Services\ServiceResource;
use App\Http\Controllers\Api\ApiController;
use App\TheApp\CustomClass\PreviewCheck;
use Illuminate\Http\Request;
use Auth;

class PreviewController extends ApiController
{
    function __construct(Preveiew $preview)
    {
        $this->previewModel  = $preview;
    }
    
    public function checkDates(Request $request)
    {
        $dates = PreviewCheck::getPreviews($request['service_id'],$request['governorate_id']);
        return $this->responseMessages($dates,true,200);
    }

    public function services()
    {
        $data = ServiceResource::collection($this->previewModel->getServices());

        return $this->responseMessages($data,true,200);
    }

    public function request(Request $request)
    {
        $preview = $this->previewModel->userCreateRequest($request);

        if ($preview)
            return $this->responseMessages(new PreviewResource($preview),true,200);

        return $this->responseMessages([],false,405,[ 'please try again ']);
    }

    public function myPreviews(Request $request)
    {
        $previews = $this->previewModel->myPreviews($request);

        return $this->responseMessages(PreviewResource::collection($previews),true,200);
    }
    
    public function myPreview(Request $request,$id)
    {
        $order = $this->previewModel->previewById($id);

        if ($order)
            return $this->responseMessages(new PreviewResource($order),true,200);

        return $this->responseMessages([],false,405,['no order with this id']);
    }
}

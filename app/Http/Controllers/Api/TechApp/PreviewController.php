<?php

namespace App\Http\Controllers\Api\TechApp;

use App\TheApp\Repository\Api\Previews\PreviewRepository as Preveiew;
use App\Http\Resources\Previews\PreviewResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class PreviewController extends ApiController
{
    function __construct(Preveiew $preview)
    {
        $this->previewModel  = $preview;
    }

    public function myPreviews(Request $request)
    {
        $previews = $this->previewModel->techPreviews($request);

        return $this->responseMessages(PreviewResource::collection($previews),true,200);
    }
    
    public function myPreview(Request $request,$id)
    {
        $preview = $this->previewModel->techPreviewById($id);

        if ($preview)
            return $this->responseMessages(new PreviewResource($preview),true,200);

        return $this->responseMessages([],false,405,['no preview with this id']);
    }

    public function changeStatus(Request $request,$id)
    {
        $preview = $this->previewModel->previewChangeStatus($request,$id);

        if ($preview)
            return $this->responseMessages(new PreviewResource($preview),true,200);

        return $this->responseMessages([],false,405,['no preview with this id']);
    }
}

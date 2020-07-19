<?php

namespace App\Http\Controllers\Api\V2\UserApp;

use App\TheApp\Repository\Api\V2\Ads\AdsRepository as Ads;
use App\Http\Resources\Ads\AdsResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class AdsController extends ApiController
{
    public function __construct(Ads $ads)
    {
        $this->adsModel  = $ads;
    }

    public function ads()
    {
        $adss = $this->adsModel->getAll();

        return $this->responseMessages(AdsResource::collection($adss), true, 200);
    }
}

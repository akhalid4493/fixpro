<?php

namespace App\Http\Controllers\Api\UserApp;

use App\TheApp\Repository\Api\Tokens\DeviceTokensRepository;
use App\TheApp\Repository\Api\General\GeneralRepository;
use App\Http\Resources\Settings\SettingResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Pages\PageResource;
use Illuminate\Http\Request;

class GlobalController extends ApiController
{
    function __construct(GeneralRepository $general,DeviceTokensRepository $token)
    {
        $this->generalModel = $general;
        $this->tokenModel   = $token;
    }

    public function settings()
    {
        $settings = $this->generalModel->getAllSettings();
        $data = SettingResource::collection($settings);

        return $this->responseMessages($data,true,200);
    }

    public function setting(Request $request)
    {
        $value = $this->generalModel->getSettingByKey($request['key']);

        if ($value != null)
            return $this->responseMessages(new SettingResource($value),true,200);

        return $this->responseMessages([],false,404,[ 'the key not found']);
    }

    public function pages()
    {
        $pages = $this->generalModel->getAllPages();
        return $this->responseMessages(PageResource::collection($pages),true,200);
    }

    public function page($id)
    {
        $page = $this->generalModel->getPageById($id);

        if ($page != null)
            return $this->responseMessages(new PageResource($page),true,200);

        return $this->responseMessages([],false,404,[ 'page not found']);
    }

    public function deviceToken(Request $request)
    {
        $update  = $this->tokenModel->deviceToken($request);

        if ($update == true)        
            return $this->responseMessages('device token updated' ,true,200,[]);

        return $this->responseMessages([],false,405,['can not update']);
    }
}

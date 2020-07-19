<?php

namespace App\Http\Controllers\Api\V1\UserApp;

use App\Http\Resources\Governorates\GovernorateResource;
use App\TheApp\Repository\Api\V1\Users\AddressRepository;
use App\Http\Resources\Provinces\ProvinceResource;
use App\Http\Resources\User\AddressResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;


class UserAddressController extends ApiController
{
	function __construct(AddressRepository $address)
    {
        $this->addressModel = $address;
    }

    public function governorates()
    {
    	$governorates = $this->addressModel->allGovernorates();
        return $this->responseMessages(GovernorateResource::collection($governorates),true,200);
    }

    public function provinces(Request $request)
    {
    	$provinces = $this->addressModel->allProvinces($request);
        return $this->responseMessages(ProvinceResource::collection($provinces),true,200);
    }

	public function myAddresses(Request $request)
	{
		if (Auth::user()->address != '')
			return $this->responseMessages(AddressResource::collection(Auth::user()->address),true,200);

		return $this->responseMessages([],false,405,['there is no address for this user']);
	}

	public function create(Request $request)
	{
		$userAddress = $this->addressModel->createAddress($request);

		if($userAddress)
			return $this->responseMessages(new AddressResource($userAddress),true,200);

		return $this->responseMessages([],false,405,['try again']);
	}

	public function update(Request $request,$id)
	{
		$userAddress = $this->addressModel->updateAddress($request,$id);

		if ($userAddress) {

			return $this->responseMessages(new AddressResource($userAddress),true,200);
    	}

		return $this->responseMessages([],false,405,['there is no address for this user']);
	}

	public function delete($id)
	{
		if (Auth::user()->address != '') {

			$userAddress = $this->addressModel->deleteAddress($id);

			if ($userAddress){
				return $this->responseMessages('address deleted',true,200);
			}else{
				return $this->responseMessages([],false,405,['there is no address for this user']);
			}

    	}

		return $this->responseMessages([],false,405,['there is no address for this user']);
	}
}

<?php

namespace App\Http\Controllers\Api\UserApp;

use App\TheApp\Repository\Api\Packages\PackageRepository as Package;
use App\Http\Resources\Packges\PackageResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class PackageController extends ApiController
{
   	function __construct(Package $package)
    {
        $this->packageModel  = $package;
    }

	/*
 	===============================================
  			SUBSCRIPTION & PACKAGES METHODS
    =============================================== 
    */
  	
  	public function myPackages()
	{
		$packages = $this->packageModel->getAll();

		if ($packages->isNotEmpty())
			return $this->responseMessages(PackageResource::collection($packages),true,200);

		return $this->responseMessages([],false,405,['there is no packages']);
	}

	public function getPackage($id)
	{
		$package = $this->packageModel->packageById($id);

		if ($package)
			return $this->responseMessages(new PackageResource($package),true,200);

		return $this->responseMessages([],false,405,['no packages with this id']);
	}

	public function subscription(Request $request)
	{
		$package = $this->packageModel->myPackageById($request['package_id']);

		if ($package) {
			$payment = $this->payment->send($request);
			return $payment;
		}
	}
}

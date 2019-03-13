<?php

namespace App\Http\Controllers\Api\UserApp;

use App\Http\Controllers\Payment\SubscriptionPaymentController as Payment;
use App\TheApp\Repository\Api\Packages\PackageRepository as Package;
use App\Http\Resources\Packges\PackageResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Auth;

class PackageController extends ApiController
{
   	function __construct(Package $package,Payment $payment)
    {
        $this->payment 		 = $payment;
        $this->packageModel  = $package;
    }

	/*
 	===============================================
  			SUBSCRIPTION & PACKAGES METHODS
    =============================================== 
    */
  	
  	public function myPackages()
	{
		$packages = $this->packageModel->myPackages();

		if ($packages->isNotEmpty())
			return $this->responseMessages(PackageResource::collection($packages),true,200);

		return $this->responseMessages([],false,405,['there is no packages for this user']);
	}

	public function getPackage($id)
	{
		$package = $this->packageModel->myPackageById($id);

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

<?php

namespace App\Http\Controllers\Api\TechApp;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\TheApp\Requests\Api\Users\UpdateProfileRequest;
use App\TheApp\Repository\Api\Users\UserRepository;
use App\TheApp\Requests\Api\Users\RegisterRequest;
use App\TheApp\Requests\Api\Users\ChangePassword;
use App\TheApp\Requests\Api\Users\LoginRequest;
use App\Http\Resources\User\AddressResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Auth;

class UserController extends ApiController
{
	use SendsPasswordResetEmails;
   
	function __construct(UserRepository $user)
    {
        $this->userModel = $user;

    	$this->middleware('apiTechAuth', [
	    	'only' => [ 
	    			'profile' ,  
    				'checkToken' , 
    				'updateProfile' , 
    				'updatePic' , 
    				'updateDeviceId' ,
    				'changePassword',
    				'changePassword' ,
    				'address',
    				'getAddress',
    				'updateAddress',
    				'deleteUserAddress'
	    		]
		]);
    }

    // Login action 
	public function login(LoginRequest $request)
	{
		$user = $this->userModel->techLogin($request);

		// Check login success & return with user data if login
		if ($user == true)
			return $this->responseMessages(new UserResource(Auth::user()),true,200);

		return $this->responseMessages([],false,401,[trans('app/api/usersApi.notAuth')]);
	}

	// User profile data
	public function profile(Request $request)
	{
		return $this->responseMessages(new UserResource(Auth::user()),true,200);
	}

    //Check API Token 
	public function checkToken(Request $request)
	{
		return $this->responseMessages('Api token found' ,true,200,[]);
	}

	// UPDATE PROIFLE INFO
	public function updateProfile(UpdateProfileRequest $request)
	{
		$userUpdate = $this->userModel->update($request);

		if ($userUpdate == true)	
			return $this->responseMessages(new UserResource($userUpdate),true,200);
	}

	// UPDATE PROFILE PIC
	public function updatePic(Request $request)
	{
		$userUpdate = $this->userModel->updatePic($request);

		if ($userUpdate == true)
			return $this->responseMessages(new UserResource($userUpdate),true,200);

		return $this->responseMessages([],false,405,[ 'can not update']);
	}

	// UPDATE DEVICE TOKEN
	public function updateDeviceId(Request $request)
	{
		$update  = $this->userModel->updateDeviceId($request);

		if ($update == true)		
			return $this->responseMessages('device token updated' ,true,200,[]);

		return $this->responseMessages([],false,405,[ 'can not update']);
	}


	// UPDATE DEVICE TOKEN
	public function deviceToken(Request $request)
	{
		$update  = $this->userModel->deviceToken($request);

		if ($update == true)		
			return $this->responseMessages('device token updated' ,true,200,[]);

		return $this->responseMessages([],false,405,[ 'can not update']);
	}

	// CHANGE PASSWORD
	public function changePassword(ChangePassword $request)
	{
		$result = $this->userModel->changePassword($request);
			
		if ($result == true)
			return $this->responseMessages(new UserResource(Auth::user()),true,200);

		return $this->responseMessages([],false,405,[ 'The old password is incorrect']);
	}
	

	// Add User Address
	public function address(Request $request)
	{
		$userAddress = $this->userModel->createAddress($request);
		
		if($userAddress)
			return $this->responseMessages(new AddressResource($userAddress),true,200);

		return $this->responseMessages([],false,405,['try again']);
	}

	// Get User Address
	public function getAddress(Request $request)
	{
		if (Auth::user()->address != '')
			return $this->responseMessages(AddressResource::collection(Auth::user()->address),true,200);

		return $this->responseMessages([],false,405,[ 'there is no address for this user']);
	}

	// Update User Address
	public function updateAddress(Request $request)
	{
		if (Auth::user()->address != '') {

			$userAddress = $this->userModel->updateAddress($request);

			return $this->responseMessages('address updated',true,200);
    	}

		return $this->responseMessages([],false,405,[ 'there is no address for this user']);
	}


	// Delete User Address
	public function deleteUserAddress(Request $request)
	{
		if (Auth::user()->address != '') {

			$userAddress = $this->userModel->deleteAddress($request);

			if ($userAddress) 
				return $this->responseMessages('address deleted',true,200);

    	}

		return $this->responseMessages([],false,405,['there is no address for this user']);
	}

	public function __invoke(Request $request)
    {
        $this->validateEmail($request);
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if($request->expectsJson()){
            
        return $response = Password::RESET_LINK_SENT
            ? $this->responseMessages(['Reset Password Link Sent'],true,200)
            : $this->responseMessages([],false,405,[ 'Reset Link Could Not Be Sent']);
        }
    }
}

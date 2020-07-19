<?php

namespace App\Http\Controllers\Api\V2\UserApp;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\TheApp\Requests\Api\Users\UpdateProfileRequest;
use App\TheApp\Repository\Api\V2\Users\UserRepository;
use App\TheApp\Requests\Api\Users\RegisterRequest;
use App\TheApp\Requests\Api\Users\ChangePassword;
use App\TheApp\Requests\Api\Users\LoginRequest;
use App\Http\Resources\User\AddressResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;

class UserController extends ApiController
{
	use SendsPasswordResetEmails;

	function __construct(UserRepository $user)
    {
        $this->userModel = $user;
    }

    /**
     * Login user for the app and get {Json Web Token}.
     */
    public function login(LoginRequest $request)
	{
		$token = $this->userModel->login($request);

		if ($token)
			return $this->responseMessages($this->tokenRespons($token),true,200);

		return $this->responseMessages([],false,401,['Unauthenticated']);
	}

	/**
     * Register new user for the app and get {Json Web Token}.
     */
	public function register(RegisterRequest $request)
	{
		$token = $this->userModel->register($request);

		if ($token)
			return $this->responseMessages($this->tokenRespons(JWTAuth::fromUser($token)),true,200);

		return $this->responseMessages([],false,401,['Ops! , try again']);
	}

	/**
     * Show profile of the user.
     */
	public function profile()
	{
		$user = new UserResource(Auth::user());
		return $this->responseMessages($user,true,200);
	}

	/**
     * Update the user information.
     */
	public function updateProfile(UpdateProfileRequest $request)
	{
		$userUpdate = $this->userModel->update($request);

		if ($userUpdate){
			$user = new UserResource(Auth::user());
			return $this->responseMessages($user,true,200);
		}
	}

	/**
     * Update the avatar of the user.
     */
	public function avatar(Request $request)
	{
		$update = $this->userModel->avatar($request);

		if ($update){
			$user = new UserResource(Auth::user());
			return $this->responseMessages($user,true,200);
		}

		return $this->responseMessages([],false,405,['can not update']);
	}

	/**
     * Change the password of user.
     */
	public function changePassword(ChangePassword $request)
	{
		$result = $this->userModel->changePassword($request);

		if ($result)
			return $this->responseMessages(new UserResource(Auth::user()),true,200);

		return $this->responseMessages([],false,405,[ 'The old password is incorrect']);
	}

	/**
     * Logout and destroy the session of JWT.
     */
	public function logout(Request $request)
	{
        $logout = auth()->logout();

		return $this->responseMessages('User logout successfully' ,true,200,[]);
	}

	/**
     * Send the forget password mail for user.
     */
	public function __invoke(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if($request->expectsJson()){

        	return $response = Password::RESET_LINK_SENT
            	? $this->responseMessages(['Reset Password Link Sent'],true,200)
            	: $this->responseMessages([],false,405,[ 'Reset Link Could Not Be Sent']);
        }
    }

    /**
     * JWT Method.
     */
    protected function tokenRespons($token)
    {
        return [
            'access_token' 	=> $token,
            'token_type' 	=> 'bearer',
            'expires_in' 	=> auth('api')->factory()->getTTL() * 60
        ];
    }
}

<?php
namespace App\TheApp\Repository\Api\Users;

use App\Models\User;
use ImageTrait;
use JWTAuth;
use Auth;
use Hash;
use DB;

class UserRepository
{
    protected $model;

    function __construct(User $user)
    {
        $this->model        = $user;
    }    

    public function techLogin($data)
    {
        $token = JWTAuth::attempt([
                'email'     => $data['email'],
                'password'  => $data['password'], 
                'active'    => 1
            ]);

        if ($token) {

            if (auth()->user()->can('technical_team')) {
                return $token;
            }
            
        }
            

        return false;
    }

    public function login($data)
    {
        $token = JWTAuth::attempt([
                'email'     => $data['email'],
                'password'  => $data['password'], 
                'active'    => 1
            ]);

        return $token;
    }

    public function register($request)
    {
        DB::beginTransaction();

        $img = ImageTrait::copyImage('users/user.png','users/'.ar_slug($request->name),'user.png');

        try {
            
            $user = $this->model->create([
                    'name'          => $request['name'],
                    'email'         => $request['email'],
                    'mobile'        => $request['mobile'],
                    'password'      => bcrypt($request['password']),
                    'active'        => 1,
                    'image'         => $img,
                ]);

            DB::commit();
            
            return $user;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {
            
            Auth::user()->update([
                    'name'          => $request['name'],
                    'email'         => $request['email'],
                    'mobile'        => $request['mobile'],
            ]);


            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function avatar($request)
    {
        DB::beginTransaction();

        $user = Auth::user();

        $img = ImageTrait::uploadImage($request->avatar,'users/'.ar_slug($user->name),$user->image);

        try {
            
            $user->update([
                'image' => $img,
            ]);


            DB::commit();
            return $user;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function changePassword($data)
    {
        $user = Auth::user();
        $current_password = $user->password;

        if(Hash::check($data['old_password'] , $current_password))
        {
            $user->update([
                'password' => bcrypt($data['new_password'])
            ]);

            return true;
        }

        return false;
    }

}
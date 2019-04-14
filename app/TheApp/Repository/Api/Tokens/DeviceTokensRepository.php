<?php
namespace App\TheApp\Repository\Api\Tokens;

use App\Models\DeviceToken;
use Auth;
use DB;

class DeviceTokensRepository
{
    protected $model;

    function __construct(DeviceToken $deviceToken)
    {
        $this->deviceToken  = $deviceToken;
    }  

    public function deviceToken($data)
    {
        DB::beginTransaction();
        
        $this->checkUserId($data);

        try {
                        
            $user = $this->deviceToken->updateOrCreate([
                'device_token' => $data['device_token'],
            ],
            [
                'device_token' => $data['device_token'],
                'user_id'      => $data['user_id'],
                'platform'     => $data['platform'],
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function checkUserId($data)
    {
        $tokens = $this->deviceToken->where('user_id', '=', $data['user_id'])->get();

        foreach ($tokens as $token) {

            $token->update([
                'user_id' => null
            ]);
            
        }
    }
}
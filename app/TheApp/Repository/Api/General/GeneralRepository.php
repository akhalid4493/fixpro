<?php
namespace App\TheApp\Repository\Api\General;

use Illuminate\Http\Request;
use App\Models\DeviceToken;
use App\Models\Setting;
use App\Models\Page;
use Auth;
use DB;

class GeneralRepository
{
    protected $model;

    function __construct(Setting $setting,Page $page,DeviceToken $deviceToken)
    {
        $this->setting      = $setting;
        $this->page         = $page;
        $this->deviceToken  = $deviceToken;
    }  

    public function getAllPages()
    {
        $pages = $this->page
               ->where('status',1)
               ->orderBy('id','desc')
               ->get();

        return $pages;
    }

    public function getPageById($id)
    {
        $page = $this->page->find($id);

        return $page;
    }

    public function getAllSettings()
    {
        $settings = $this->setting
               ->orderBy('id','desc')
               ->get();

        return $settings;
    }

    public function getSettingByKey($key)
    {
        $setting = $this->setting->where('name',$key)->first();

        return $setting;
    }

    public function deviceToken($data)
    {
        DB::beginTransaction();

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
}
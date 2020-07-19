<?php
namespace App\TheApp\Repository\Api\V2\General;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Page;
use Auth;
use DB;

class GeneralRepository
{
    protected $model;

    function __construct(Setting $setting,Page $page)
    {
        $this->setting      = $setting;
        $this->page         = $page;
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
}

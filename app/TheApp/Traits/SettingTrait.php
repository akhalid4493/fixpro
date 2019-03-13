<?php

namespace App\TheApp\Traits;

use App\Models\Setting;
use ImageTrait;

trait SettingTrait
{

    static public function updateSettings($requests)
    {
	    $settings = [];

	    foreach ($requests as $key => $value) {
	        $settings[$key] = Setting::where('name' , $key)
	        				  ->where('name','!=','logo')
	        				  ->where('name','!=','favicon')
	        				  ->update(['value'=>$value]);
	    }

    	$updateFavIcon = self::updateFavIcon($requests);
    	$updateLogo = self::updateLogo($requests);

        return back()->with(['msg'=>'The Setting Updated' , 'alert'=>'success']);
    }

    static public function updateLogo($requests)
    {
    	if (!empty($requests['logo'])) {
    		$oldLogo = settings('logo');
    		$image = ImageTrait::uploadImage($requests['logo'],'settings',$oldLogo);
    	}else{
	    	$image = $requests['old_logo'];
    	}

		Setting::where('name' , 'logo')->update(['value' => $image]);
    }

    static public function updateFavIcon($requests)
    {
		if (!empty($requests['favicon'])) {
    		$oldfavicon = settings('favicon');
    		$image = ImageTrait::uploadImage($requests['favicon'],'settings',$oldfavicon);
    	}else{
	    	$image = $requests['old_favicon'];
    	}

		Setting::where('name' , 'favicon')->update(['value' => $image]);
    }

    static public function getValue($name)
	{
		$setting = Setting::where('name',$name)->first();
        return $setting ? $setting->value : '';
	}

}
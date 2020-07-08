<?php

Route::group(['prefix' => 'settings'], function () {

		Route::get('service_notifications' ,'Admin\SettingController@service_notifications')
		->name('service_notifications.index')
	  ->middleware(['permission:show_service_notifications']);

		Route::get('/' ,'Admin\SettingController@index')
		->name('settings.index')
	  ->middleware(['permission:show_settings']);

		Route::post('/'			,'Admin\SettingController@store')
		->name('settings.store')
	  ->middleware(['permission:add_settings']);

});

<?php

Route::group(['prefix' => 'packages','middleware' => ['auth:api']], function () {

	Route::get('/' 				,'Api\UserApp\PackageController@myPackages');
	Route::get('/{id}' 			,'Api\UserApp\PackageController@getPackage');
	Route::post('subscription' 	,'Api\UserApp\PackageController@subscription');
	
});
<?php

Route::group(['prefix' => 'packages','middleware' => ['auth:api']], function () {

	Route::post('subscription' 	,'Api\UserApp\PackageController@subscription');
	
});

Route::group(['prefix' => 'packages'], function () {

	Route::get('/' 				,'Api\UserApp\PackageController@myPackages');
	Route::get('/{id}' 			,'Api\UserApp\PackageController@getPackage');
	
});


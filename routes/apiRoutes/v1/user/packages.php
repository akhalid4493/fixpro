<?php

Route::group(['prefix' => 'packages','middleware' => ['auth:api']], function () {

		Route::post('subscription' 	,'Api\V1\UserApp\PackageController@subscription');
		Route::get('/' 							,'Api\V1\UserApp\PackageController@myPackages');
		Route::get('/{id}' 					,'Api\V1\UserApp\PackageController@getPackage');

});

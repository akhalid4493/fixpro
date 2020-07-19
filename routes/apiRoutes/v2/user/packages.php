<?php

Route::group(['prefix' => 'packages','middleware' => ['auth:api']], function () {

		Route::post('subscription' 	,'Api\V2\UserApp\PackageController@subscription');
		Route::get('/' 							,'Api\V2\UserApp\PackageController@myPackages');
		Route::get('/{id}' 					,'Api\V2\UserApp\PackageController@getPackage');

});

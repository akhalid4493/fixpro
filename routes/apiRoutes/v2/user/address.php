<?php

Route::group(['prefix' => 'address'], function () {

	Route::get('governorates' 	,'Api\V2\UserApp\UserAddressController@governorates');
	Route::get('provinces' 			,'Api\V2\UserApp\UserAddressController@provinces');

});

Route::group(['prefix' => 'address','middleware' => ['auth:api']], function () {

	Route::get('/' 							,'Api\V2\UserApp\UserAddressController@myAddresses');
	Route::post('add' 					,'Api\V2\UserApp\UserAddressController@create');
	Route::post('update/{id}'		,'Api\V2\UserApp\UserAddressController@update');
	Route::post('delete/{id}' 	,'Api\V2\UserApp\UserAddressController@delete');

});

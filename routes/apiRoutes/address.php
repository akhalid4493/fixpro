<?php

Route::group(['prefix' => 'address'], function () {

	Route::get('governorates' 	,'Api\UserApp\UserAddressController@governorates');
	Route::get('provinces' 		,'Api\UserApp\UserAddressController@provinces');

});

Route::group(['prefix' => 'address','middleware' => ['auth:api']], function () {

	Route::get('/' 				,'Api\UserApp\UserAddressController@myAddresses');
	Route::post('add' 			,'Api\UserApp\UserAddressController@create');
	Route::post('update/{id}'	,'Api\UserApp\UserAddressController@update');
	Route::post('delete/{id}' 	,'Api\UserApp\UserAddressController@delete');

});
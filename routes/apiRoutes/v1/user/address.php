<?php

Route::group(['prefix' => 'address'], function () {

	Route::get('governorates' 	,'Api\V1\UserApp\UserAddressController@governorates');
	Route::get('provinces' 			,'Api\V1\UserApp\UserAddressController@provinces');

});

Route::group(['prefix' => 'address','middleware' => ['auth:api']], function () {

	Route::get('/' 								,'Api\V1\UserApp\UserAddressController@myAddresses');
	Route::post('add' 						,'Api\V1\UserApp\UserAddressController@create');
	Route::post('update/{id}'			,'Api\V1\UserApp\UserAddressController@update');
	Route::post('delete/{id}' 		,'Api\V1\UserApp\UserAddressController@delete');

});

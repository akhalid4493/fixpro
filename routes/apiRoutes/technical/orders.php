<?php

Route::group(['prefix' => 'orders','middleware' => ['auth:api','technical']], function () {

	Route::get('products' 			,'Api\TechApp\StoreController@products');
	Route::get('product/{id}' 		,'Api\TechApp\StoreController@product');
	Route::get('installations' 		,'Api\TechApp\StoreController@installations');
	Route::get('installation/{id}' 	,'Api\TechApp\StoreController@installation');
	Route::post('create' 			,'Api\TechApp\StoreController@createOrder');

});
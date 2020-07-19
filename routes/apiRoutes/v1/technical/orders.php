<?php

Route::group(['prefix' => 'orders','middleware' => ['auth:api','technical']], function () {

	Route::get('categories' 					,'Api\V1\TechApp\StoreController@categories');
	Route::get('products' 						,'Api\V1\TechApp\StoreController@products');
	Route::get('product/{id}' 				,'Api\V1\TechApp\StoreController@product');
	Route::get('installations' 				,'Api\V1\TechApp\StoreController@installations');
	Route::get('installation/{id}' 		,'Api\V1\TechApp\StoreController@installation');
	Route::post('create' 							,'Api\V1\TechApp\StoreController@createOrder');
	Route::get('/' 										,'Api\V1\TechApp\StoreController@myOrders');
	Route::get('{id}' 								,'Api\V1\TechApp\StoreController@getOrder');

});

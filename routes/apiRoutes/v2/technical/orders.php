<?php

Route::group(['prefix' => 'orders','middleware' => ['auth:api','technical']], function () {

	Route::get('categories' 				,'Api\V2\TechApp\StoreController@categories');
	Route::get('products' 					,'Api\V2\TechApp\StoreController@products');
	Route::get('product/{id}' 			,'Api\V2\TechApp\StoreController@product');
	Route::get('installations' 			,'Api\V2\TechApp\StoreController@installations');
	Route::get('installation/{id}' 	,'Api\V2\TechApp\StoreController@installation');
	Route::post('create' 						,'Api\V2\TechApp\StoreController@createOrder');
	Route::get('/' 									,'Api\V2\TechApp\StoreController@myOrders');
	Route::get('{id}' 							,'Api\V2\TechApp\StoreController@getOrder');

});

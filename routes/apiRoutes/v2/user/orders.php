<?php


Route::group(['prefix' => 'orders','middleware' => ['auth:api']], function () {

	Route::post('action/{id}' 	,'Api\V2\UserApp\OrderController@orderAction');
	Route::get('/' 							,'Api\V2\UserApp\OrderController@myOrders');
	Route::get('{id}' 					,'Api\V2\UserApp\OrderController@getOrder');

});

Route::get('failed' 				,'Api\V2\UserApp\OrderController@failed')->name('api.orders.failed');
Route::get('success' 				,'Api\V2\UserApp\OrderController@success')->name('api.orders.success');
Route::post('webhooks' 			,'Api\V2\UserApp\OrderController@webhooks')->name('api.orders.webhooks');

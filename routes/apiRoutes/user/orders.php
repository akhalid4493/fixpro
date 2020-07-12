<?php


Route::group(['prefix' => 'orders','middleware' => ['auth:api']], function () {

	Route::post('action/{id}' 	,'Api\UserApp\OrderController@orderAction');
	Route::get('/' 							,'Api\UserApp\OrderController@myOrders');
	Route::get('{id}' 					,'Api\UserApp\OrderController@getOrder');

});

Route::get('failed' 				,'Api\UserApp\OrderController@failed')->name('api.orders.failed');
Route::get('success' 				,'Api\UserApp\OrderController@success')->name('api.orders.success');
Route::post('webhooks' 			,'Api\UserApp\OrderController@webhooks')->name('api.orders.webhooks');

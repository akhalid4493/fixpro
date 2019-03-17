<?php

Route::group(['prefix' => 'orders','middleware' => ['auth:api']], function () {

	Route::get('/' 				,'Api\UserApp\OrderController@myOrders');
	Route::get('{id}' 			,'Api\UserApp\OrderController@getOrder');
	Route::post('{id}/action' 	,'Api\UserApp\OrderController@orderAction');

});
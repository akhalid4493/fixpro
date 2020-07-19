<?php

Route::group(['prefix' => 'orders','middleware' => ['auth:api']], function () {

	Route::get('/' 							,'Api\V1\UserApp\OrderController@myOrders');
	Route::get('{id}' 					,'Api\V1\UserApp\OrderController@getOrder');
	Route::post('{id}/action' 	,'Api\V1\UserApp\OrderController@orderAction');

});

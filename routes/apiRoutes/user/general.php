<?php

Route::group(['prefix' => 'general'], function () {

	Route::post('subscription-request' 	,'Api\UserApp\GlobalController@SubscriptionRequest');
	Route::post('device-token' 			,'Api\UserApp\GlobalController@deviceToken');
	Route::get('settings' 				,'Api\UserApp\GlobalController@settings');
	Route::get('setting' 				,'Api\UserApp\GlobalController@setting');
	Route::get('pages' 					,'Api\UserApp\GlobalController@pages');
	Route::get('page/{id}' 				,'Api\UserApp\GlobalController@page');

});
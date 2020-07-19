<?php

Route::group(['prefix' => 'general'], function () {

	Route::post('subscription-request' 	,'Api\V1\UserApp\GlobalController@SubscriptionRequest');
	Route::post('device-token' 					,'Api\V1\UserApp\GlobalController@deviceToken');
	Route::get('settings' 							,'Api\V1\UserApp\GlobalController@settings');
	Route::get('setting' 								,'Api\V1\UserApp\GlobalController@setting');
	Route::get('pages' 									,'Api\V1\UserApp\GlobalController@pages');
	Route::get('page/{id}' 							,'Api\V1\UserApp\GlobalController@page');

});

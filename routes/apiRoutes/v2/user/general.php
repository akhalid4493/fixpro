<?php

Route::group(['prefix' => 'general'], function () {

			Route::post('subscription-request' 	,'Api\V2\UserApp\GlobalController@SubscriptionRequest');
			Route::post('device-token' 					,'Api\V2\UserApp\GlobalController@deviceToken');
			Route::get('settings' 							,'Api\V2\UserApp\GlobalController@settings');
			Route::get('setting' 								,'Api\V2\UserApp\GlobalController@setting');
			Route::get('pages' 									,'Api\V2\UserApp\GlobalController@pages');
			Route::get('page/{id}' 							,'Api\V2\UserApp\GlobalController@page');

});

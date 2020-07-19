<?php

Route::group(['prefix' => 'previews'], function () {

	Route::get('services' 			,'Api\V1\UserApp\PreviewController@services');
	Route::post('check-dates' 	,'Api\V1\UserApp\PreviewController@checkDates');

});

Route::group(['prefix' => 'previews','middleware' =>['auth:api']], function () {

	Route::get('/' 						,'Api\V1\UserApp\PreviewController@myPreviews');
	Route::get('/{id}' 				,'Api\V1\UserApp\PreviewController@myPreview');
	Route::post('request' 		,'Api\V1\UserApp\PreviewController@request');

});

<?php

Route::group(['prefix' => 'previews'], function () {

	Route::get('services' 	,'Api\UserApp\PreviewController@services');

});

Route::group(['prefix' => 'previews','middleware' => ['auth:api']], function () {

	Route::get('/' 			,'Api\UserApp\PreviewController@myPreviews');
	Route::get('/{id}' 		,'Api\UserApp\PreviewController@myPreview');
	Route::post('request' 	,'Api\UserApp\PreviewController@request');

});
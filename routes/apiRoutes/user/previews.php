<?php

Route::group(['prefix' => 'previews'], function () {

	Route::get('categories' 		,'Api\UserApp\PreviewController@categories');
	Route::get('services' 			,'Api\UserApp\PreviewController@services');
	Route::post('check-dates' 	,'Api\UserApp\PreviewController@checkDates');
	Route::get('failed' 				,'Api\UserApp\PreviewController@failed')->name('api.previews.failed');
	Route::get('success' 				,'Api\UserApp\PreviewController@success')->name('api.previews.success');
	Route::post('webhooks' 			,'Api\UserApp\PreviewController@webhooks')->name('api.previews.webhooks');

});

Route::group(['prefix' => 'previews','middleware' =>['auth:api']], function () {

	Route::get('/' 					,'Api\UserApp\PreviewController@myPreviews');
	Route::get('/{id}' 			,'Api\UserApp\PreviewController@myPreview');
	Route::post('request' 	,'Api\UserApp\PreviewController@request');

});

<?php

Route::group(['prefix' => 'previews'], function () {

	Route::get('categories' 		,'Api\V2\UserApp\PreviewController@categories');
	Route::get('services' 			,'Api\V2\UserApp\PreviewController@services');
	Route::post('check-dates' 	,'Api\V2\UserApp\PreviewController@checkDates');
	Route::get('failed' 				,'Api\V2\UserApp\PreviewController@failed')->name('api.previews.failed');
	Route::get('success' 				,'Api\V2\UserApp\PreviewController@success')->name('api.previews.success');
	Route::post('webhooks' 			,'Api\V2\UserApp\PreviewController@webhooks')->name('api.previews.webhooks');

});

Route::group(['prefix' => 'previews','middleware' =>['auth:api']], function () {

	Route::get('/' 					,'Api\V2\UserApp\PreviewController@myPreviews');
	Route::get('/{id}' 			,'Api\V2\UserApp\PreviewController@myPreview');
	Route::post('request' 	,'Api\V2\UserApp\PreviewController@request');

});

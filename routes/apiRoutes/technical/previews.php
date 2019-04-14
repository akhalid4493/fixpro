<?php

Route::group(['prefix' => 'previews','middleware' => ['auth:api','technical','jwt.refresh']],function() {

	Route::get('/' 				,'Api\TechApp\PreviewController@myPreviews');
	Route::get('/{id}' 			,'Api\TechApp\PreviewController@myPreview');
	Route::post('/{id}/action' 	,'Api\TechApp\PreviewController@changeStatus');

});
<?php

Route::group(['prefix' => 'previews','middleware' => ['auth:api','technical']],function() {

	Route::get('/' 									,'Api\TechApp\PreviewController@myPreviews');
	Route::get('/{id}' 							,'Api\TechApp\PreviewController@myPreview');
	Route::post('/{id}/gallery' 		,'Api\TechApp\PreviewController@previewTechGallery');
	Route::post('/{id}/action' 			,'Api\TechApp\PreviewController@changeStatus');
	Route::post('/{id}/seen' 		  	,'Api\TechApp\PreviewController@seen');

});

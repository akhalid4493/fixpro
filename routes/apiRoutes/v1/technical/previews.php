<?php

Route::group(['prefix' => 'previews','middleware' => ['auth:api','technical']],function() {

	Route::get('/' 									,'Api\V1\TechApp\PreviewController@myPreviews');
	Route::get('/{id}' 							,'Api\V1\TechApp\PreviewController@myPreview');
	Route::post('/{id}/gallery' 		,'Api\V1\TechApp\PreviewController@previewTechGallery');
	Route::post('/{id}/action' 			,'Api\V1\TechApp\PreviewController@changeStatus');
	Route::post('/{id}/seen' 		  	,'Api\V1\TechApp\PreviewController@seen');

});

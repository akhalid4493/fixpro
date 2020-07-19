<?php

Route::group(['prefix' => 'previews','middleware' => ['auth:api','technical']],function() {

	Route::get('/' 									,'Api\V2\TechApp\PreviewController@myPreviews');
	Route::get('/{id}' 							,'Api\V2\TechApp\PreviewController@myPreview');
	Route::post('/{id}/gallery' 		,'Api\V2\TechApp\PreviewController@previewTechGallery');
	Route::post('/{id}/action' 			,'Api\V2\TechApp\PreviewController@changeStatus');
	Route::post('/{id}/seen' 		  	,'Api\V2\TechApp\PreviewController@seen');

});

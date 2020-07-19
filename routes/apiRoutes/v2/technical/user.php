<?php

Route::group(['prefix' => 'auth'], function () {

	Route::post('login' 						,'Api\V2\TechApp\UserController@login');
	Route::post('forget-password' 	,'Api\V2\TechApp\UserController@__invoke');

});

Route::group(['prefix' => 'user','middleware' => ['auth:api','technical']], function () {

	Route::get('profile' 						,'Api\V2\TechApp\UserController@profile');
	Route::post('profile' 					,'Api\V2\TechApp\UserController@updateProfile');
	Route::post('avatar' 						,'Api\V2\TechApp\UserController@avatar');
	Route::post('change-password' 	,'Api\V2\TechApp\UserController@changePassword');
	Route::post('logout' 						,'Api\V2\TechApp\UserController@logout');

});

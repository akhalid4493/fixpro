<?php

Route::group(['prefix' => 'auth'], function () {

	Route::post('login' 						,'Api\V1\TechApp\UserController@login');
	Route::post('forget-password' 	,'Api\V1\TechApp\UserController@__invoke');

});

Route::group(['prefix' => 'user','middleware' => ['auth:api','technical']], function () {

	Route::get('profile' 						,'Api\V1\TechApp\UserController@profile');
	Route::post('profile' 					,'Api\V1\TechApp\UserController@updateProfile');
	Route::post('avatar' 						,'Api\V1\TechApp\UserController@avatar');
	Route::post('change-password' 	,'Api\V1\TechApp\UserController@changePassword');
	Route::post('logout' 						,'Api\V1\TechApp\UserController@logout');

});

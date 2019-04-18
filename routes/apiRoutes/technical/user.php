<?php

Route::group(['prefix' => 'auth'], function () {

	Route::post('login' 			,'Api\TechApp\UserController@login');
	Route::post('forget-password' 	,'Api\TechApp\UserController@__invoke');

});

Route::group(['prefix' => 'user','middleware' => ['auth:api','technical']], function () {

	Route::get('profile' 			,'Api\TechApp\UserController@profile');
	Route::post('profile' 			,'Api\TechApp\UserController@updateProfile');
	Route::post('avatar' 			,'Api\TechApp\UserController@avatar');
	Route::post('change-password' 	,'Api\TechApp\UserController@changePassword');
	Route::post('logout' 			,'Api\TechApp\UserController@logout');

});
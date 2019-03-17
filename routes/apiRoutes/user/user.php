<?php

Route::group(['prefix' => 'auth'], function () {

	Route::post('register' 			,'Api\UserApp\UserController@register');
	Route::post('login' 			,'Api\UserApp\UserController@login');
	Route::post('forget-password' 	,'Api\UserApp\UserController@__invoke');

});

Route::group(['prefix' => 'user','middleware' => ['auth:api']], function () {

	Route::get('profile' 			,'Api\UserApp\UserController@profile');
	Route::post('profile' 			,'Api\UserApp\UserController@updateProfile');
	Route::post('avatar' 			,'Api\UserApp\UserController@avatar');
	Route::post('change-password' 	,'Api\UserApp\UserController@changePassword');
	Route::post('logout' 			,'Api\UserApp\UserController@logout');

});
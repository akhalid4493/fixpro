<?php

Route::group(['prefix' => 'auth'], function () {

	Route::post('register' 					,'Api\V1\UserApp\UserController@register');
	Route::post('login' 						,'Api\V1\UserApp\UserController@login');
	Route::post('forget-password' 	,'Api\V1\UserApp\UserController@__invoke');

});

Route::group(['prefix' => 'user','middleware' => ['auth:api']], function () {

	Route::get('profile' 						,'Api\V1\UserApp\UserController@profile');
	Route::post('profile' 					,'Api\V1\UserApp\UserController@updateProfile');
	Route::post('avatar' 						,'Api\V1\UserApp\UserController@avatar');
	Route::post('change-password' 	,'Api\V1\UserApp\UserController@changePassword');
	Route::post('logout' 						,'Api\V1\UserApp\UserController@logout');

});

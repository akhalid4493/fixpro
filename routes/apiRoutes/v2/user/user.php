<?php

Route::group(['prefix' => 'auth'], function () {

		Route::post('register' 					,'Api\V2\UserApp\UserController@register');
		Route::post('login' 						,'Api\V2\UserApp\UserController@login');
		Route::post('forget-password' 	,'Api\V2\UserApp\UserController@__invoke');

});

Route::group(['prefix' => 'user','middleware' => ['auth:api']], function () {

		Route::get('profile' 						,'Api\V2\UserApp\UserController@profile');
		Route::post('profile' 					,'Api\V2\UserApp\UserController@updateProfile');
		Route::post('avatar' 						,'Api\V2\UserApp\UserController@avatar');
		Route::post('change-password' 	,'Api\V2\UserApp\UserController@changePassword');
		Route::post('logout' 						,'Api\V2\UserApp\UserController@logout');

});

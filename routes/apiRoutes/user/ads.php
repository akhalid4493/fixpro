<?php

Route::group(['prefix' => 'ads'], function () {
		Route::get('/' , 'Api\UserApp\AdsController@ads');
});

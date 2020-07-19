<?php

Route::group(['prefix' => 'ads'], function () {
		Route::get('/' , 'Api\V2\UserApp\AdsController@ads');
});

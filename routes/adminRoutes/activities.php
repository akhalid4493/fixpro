<?php

Route::group(['prefix' => 'activities'], function () {

	Route::get('/' ,'Admin\ActivityController@index')
	->name('activities.index');

	Route::get('counter' ,'Admin\ActivityController@counter')
	->name('activities.counter');

	Route::get('update' ,'Admin\ActivityController@update')
	->name('activities.update');
});

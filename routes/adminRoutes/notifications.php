<?php

Route::group(['prefix' => 'notification'], function () {

	Route::get('/' ,'Admin\NotificationController@index')
	->name('notification.index')
    ->middleware(['permission:show_notification']);

	Route::get('datatable'	,'Admin\NotificationController@dataTable')
	->name('notification.dataTable')
    ->middleware(['permission:show_notification']);

	Route::get('create'		,'Admin\NotificationController@create')
	->name('notification.create')
    ->middleware(['permission:add_notification']);

	Route::post('/'			,'Admin\NotificationController@store')
	->name('notification.store')
    ->middleware(['permission:add_notification']);

	Route::get('{id}/edit'	,'Admin\NotificationController@edit')
	->name('notification.edit')
    ->middleware(['permission:edit_notification']);

	Route::put('{id}'		,'Admin\NotificationController@update')
	->name('notification.update')
    ->middleware(['permission:edit_notification']);

	Route::delete('{id}'	,'Admin\NotificationController@destroy')
	->name('notification.destroy')
    ->middleware(['permission:delete_notification']);

	Route::get('deletes'	,'Admin\NotificationController@deletes')
	->name('notification.deletes')
    ->middleware(['permission:delete_notification']);

	Route::get('{id}','Admin\NotificationController@show')
	->name('notification.show')
    ->middleware(['permission:show_notification']);
});
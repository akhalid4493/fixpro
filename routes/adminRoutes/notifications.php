<?php

Route::group(['prefix' => 'notification'], function () {

	Route::get('/' ,'Admin\NotificationController@notifyForm')
	->name('notification.index');

	Route::get('datatable'	,'Admin\NotificationController@dataTable')
	->name('notification.dataTable');

	Route::get('create'		,'Admin\NotificationController@create')
	->name('notification.create');

	Route::post('/'			,'Admin\NotificationController@push_notification')
	->name('notification.store');

	Route::get('{id}/edit'	,'Admin\NotificationController@edit')
	->name('notification.edit');

	Route::put('{id}'		,'Admin\NotificationController@update')
	->name('notification.update');

	Route::delete('{id}'	,'Admin\NotificationController@destroy')
	->name('notification.destroy');

	Route::get('deletes'	,'Admin\NotificationController@deletes')
	->name('notification.deletes');

	Route::get('{id}','Admin\NotificationController@show')
	->name('notification.show');
});

<?php

Route::group(['prefix' => 'permissions'], function () {

	Route::get('/' ,'Admin\PermissionController@index')
	->name('permissions.index');
    // ->middleware(['auth:api']);

	Route::get('datatable'	,'Admin\PermissionController@dataTable')
	->name('permissions.dataTable');
    // ->middleware(['auth:api']);

	Route::get('create'		,'Admin\PermissionController@create')
	->name('permissions.create');
    // ->middleware(['auth:api']);

	Route::post('/'			,'Admin\PermissionController@store')
	->name('permissions.store');
    // ->middleware(['auth:api']);

	Route::get('{id}/edit'	,'Admin\PermissionController@edit')
	->name('permissions.edit');
    // ->middleware(['auth:api']);

	Route::put('{id}'		,'Admin\PermissionController@update')
	->name('permissions.update');
    // ->middleware(['auth:api']);

	Route::delete('{id}'	,'Admin\PermissionController@destroy')
	->name('permissions.destroy');
    // ->middleware(['auth:api']);

	Route::get('deletes'	,'Admin\PermissionController@deletes')
	->name('permissions.deletes');
    // ->middleware(['auth:api']);

	Route::get('{id}','Admin\PermissionController@show')
	->name('permissions.show');
    // ->middleware(['auth:api']);
	
});
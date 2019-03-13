<?php

Route::group(['prefix' => 'users'], function () {

	Route::get('/' ,'Admin\UserController@index')
	->name('users.index')
    ->middleware(['permission:show_users']);

	Route::get('datatable'	,'Admin\UserController@dataTable')
	->name('users.dataTable')
    ->middleware(['permission:show_users']);

	Route::get('create'		,'Admin\UserController@create')
	->name('users.create')
    ->middleware(['permission:add_users']);

	Route::post('/'			,'Admin\UserController@store')
	->name('users.store')
    ->middleware(['permission:add_users']);

	Route::get('{id}/edit'	,'Admin\UserController@edit')
	->name('users.edit')
    ->middleware(['permission:edit_users']);

	Route::put('{id}'		,'Admin\UserController@update')
	->name('users.update')
    ->middleware(['permission:edit_users']);

	Route::delete('{id}'	,'Admin\UserController@destroy')
	->name('users.destroy')
    ->middleware(['permission:delete_users']);

	Route::get('deletes'	,'Admin\UserController@deletes')
	->name('users.deletes')
    ->middleware(['permission:delete_users']);

	Route::get('{id}','Admin\UserController@show')
	->name('users.show')
    ->middleware(['permission:show_users']);
});
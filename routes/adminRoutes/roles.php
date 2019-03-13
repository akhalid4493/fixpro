<?php

Route::group(['prefix' => 'roles'], function () {

	Route::get('/' ,'Admin\RolesController@index')
	->name('roles.index')
    ->middleware(['permission:show_roles']);

	Route::get('datatable'	,'Admin\RolesController@dataTable')
	->name('roles.dataTable')
    ->middleware(['permission:show_users']);

	Route::get('create'		,'Admin\RolesController@create')
	->name('roles.create')
    ->middleware(['permission:add_roles']);

	Route::post('/'			,'Admin\RolesController@store')
	->name('roles.store')
    ->middleware(['permission:add_roles']);

	Route::get('{id}/edit'	,'Admin\RolesController@edit')
	->name('roles.edit')
    ->middleware(['permission:edit_roles']);

	Route::put('{id}'		,'Admin\RolesController@update')
	->name('roles.update')
    ->middleware(['permission:edit_roles']);

	Route::delete('{id}'	,'Admin\RolesController@destroy')
	->name('roles.destroy')
    ->middleware(['permission:delete_roles']);

	Route::get('deletes'	,'Admin\RolesController@deletes')
	->name('roles.deletes')
    ->middleware(['permission:delete_roles']);

	Route::get('{id}','Admin\RolesController@show')
	->name('roles.show')
    ->middleware(['permission:show_roles']);
});
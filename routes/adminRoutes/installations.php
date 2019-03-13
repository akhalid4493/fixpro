<?php

Route::group(['prefix' => 'installations'], function () {

	Route::get('/' ,'Admin\InstallationController@index')
	->name('installations.index')
    ->middleware(['permission:show_installations']);

	Route::get('datatable'	,'Admin\InstallationController@dataTable')
	->name('installations.dataTable')
    ->middleware(['permission:show_installations']);

	Route::get('create'		,'Admin\InstallationController@create')
	->name('installations.create')
    ->middleware(['permission:add_installations']);

	Route::post('/'			,'Admin\InstallationController@store')
	->name('installations.store')
    ->middleware(['permission:add_installations']);

	Route::get('{id}/edit'	,'Admin\InstallationController@edit')
	->name('installations.edit')
    ->middleware(['permission:edit_installations']);

	Route::put('{id}'		,'Admin\InstallationController@update')
	->name('installations.update')
    ->middleware(['permission:edit_installations']);

	Route::delete('{id}'	,'Admin\InstallationController@destroy')
	->name('installations.destroy')
    ->middleware(['permission:delete_installations']);

	Route::get('deletes'	,'Admin\InstallationController@deletes')
	->name('installations.deletes')
    ->middleware(['permission:delete_installations']);

	Route::get('{id}','Admin\InstallationController@show')
	->name('installations.show')
    ->middleware(['permission:show_installations']);
});
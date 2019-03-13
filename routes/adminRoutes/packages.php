<?php

Route::group(['prefix' => 'packages'], function () {

	Route::get('/' ,'Admin\PackageController@index')
	->name('packages.index')
    ->middleware(['permission:show_packages']);

	Route::get('datatable'	,'Admin\PackageController@dataTable')
	->name('packages.dataTable')
    ->middleware(['permission:show_packages']);

	Route::get('create'		,'Admin\PackageController@create')
	->name('packages.create')
    ->middleware(['permission:add_packages']);

	Route::post('/'			,'Admin\PackageController@store')
	->name('packages.store')
    ->middleware(['permission:add_packages']);

	Route::get('{id}/edit'	,'Admin\PackageController@edit')
	->name('packages.edit')
    ->middleware(['permission:edit_packages']);

	Route::put('{id}'		,'Admin\PackageController@update')
	->name('packages.update')
    ->middleware(['permission:edit_packages']);

	Route::delete('{id}'	,'Admin\PackageController@destroy')
	->name('packages.destroy')
    ->middleware(['permission:delete_packages']);

	Route::get('deletes'	,'Admin\PackageController@deletes')
	->name('packages.deletes')
    ->middleware(['permission:delete_packages']);

	Route::get('{id}','Admin\PackageController@show')
	->name('packages.show')
    ->middleware(['permission:show_packages']);
});
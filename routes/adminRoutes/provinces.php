<?php

Route::group(['prefix' => 'provinces'], function () {

	Route::get('/' ,'Admin\ProvinceController@index')
	->name('provinces.index')
    ->middleware(['permission:show_provinces']);

	Route::get('datatable'	,'Admin\ProvinceController@dataTable')
	->name('provinces.dataTable')
    ->middleware(['permission:show_provinces']);

	Route::get('create'		,'Admin\ProvinceController@create')
	->name('provinces.create')
    ->middleware(['permission:add_provinces']);

	Route::post('/'			,'Admin\ProvinceController@store')
	->name('provinces.store')
    ->middleware(['permission:add_provinces']);

	Route::get('{id}/edit'	,'Admin\ProvinceController@edit')
	->name('provinces.edit')
    ->middleware(['permission:edit_provinces']);

	Route::put('{id}'		,'Admin\ProvinceController@update')
	->name('provinces.update')
    ->middleware(['permission:edit_provinces']);

	Route::delete('{id}'	,'Admin\ProvinceController@destroy')
	->name('provinces.destroy')
    ->middleware(['permission:delete_provinces']);

	Route::get('deletes'	,'Admin\ProvinceController@deletes')
	->name('provinces.deletes')
    ->middleware(['permission:delete_provinces']);

	Route::get('{id}','Admin\ProvinceController@show')
	->name('provinces.show')
    ->middleware(['permission:show_provinces']);
});
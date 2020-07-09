<?php

Route::group(['prefix' => 'categories'], function () {

	Route::get('/' ,'Admin\CategoryController@index')
	->name('categories.index')
    ->middleware(['permission:show_categories']);

	Route::get('datatable'	,'Admin\CategoryController@dataTable')
	->name('categories.dataTable')
    ->middleware(['permission:show_categories']);

	Route::get('create'		,'Admin\CategoryController@create')
	->name('categories.create')
    ->middleware(['permission:add_categories']);

	Route::post('/'			,'Admin\CategoryController@store')
	->name('categories.store')
    ->middleware(['permission:add_categories']);

	Route::get('{id}/edit'	,'Admin\CategoryController@edit')
	->name('categories.edit')
    ->middleware(['permission:edit_categories']);

	Route::put('{id}'		,'Admin\CategoryController@update')
	->name('categories.update')
    ->middleware(['permission:edit_categories']);

	Route::delete('{id}'	,'Admin\CategoryController@destroy')
	->name('categories.destroy')
    ->middleware(['permission:delete_categories']);

	Route::get('deletes'	,'Admin\CategoryController@deletes')
	->name('categories.deletes')
    ->middleware(['permission:delete_categories']);

	Route::get('{id}','Admin\CategoryController@show')
	->name('categories.show')
    ->middleware(['permission:show_categories']);
});

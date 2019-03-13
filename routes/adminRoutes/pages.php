<?php

Route::group(['prefix' => 'pages'], function () {

	Route::get('/' ,'Admin\PageController@index')
	->name('pages.index')
    ->middleware(['permission:show_pages']);

	Route::get('datatable'	,'Admin\PageController@dataTable')
	->name('pages.dataTable')
    ->middleware(['permission:show_pages']);

	Route::get('create'		,'Admin\PageController@create')
	->name('pages.create')
    ->middleware(['permission:add_pages']);

	Route::post('/'			,'Admin\PageController@store')
	->name('pages.store')
    ->middleware(['permission:add_pages']);

	Route::get('{id}/edit'	,'Admin\PageController@edit')
	->name('pages.edit')
    ->middleware(['permission:edit_pages']);

	Route::put('{id}'		,'Admin\PageController@update')
	->name('pages.update')
    ->middleware(['permission:edit_pages']);

	Route::delete('{id}'	,'Admin\PageController@destroy')
	->name('pages.destroy')
    ->middleware(['permission:delete_pages']);

	Route::get('deletes'	,'Admin\PageController@deletes')
	->name('pages.deletes')
    ->middleware(['permission:delete_pages']);

	Route::get('{id}','Admin\PageController@show')
	->name('pages.show')
    ->middleware(['permission:show_pages']);
});
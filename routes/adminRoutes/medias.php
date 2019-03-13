<?php

Route::group(['prefix' => 'media'], function () {

	Route::get('/' ,'Admin\MediaController@index')
	->name('media.index')
    ->middleware(['permission:show_media']);

	Route::get('datatable'	,'Admin\MediaController@dataTable')
	->name('media.dataTable')
    ->middleware(['permission:show_media']);

	Route::get('create'		,'Admin\MediaController@create')
	->name('media.create')
    ->middleware(['permission:add_media']);

	Route::post('/'			,'Admin\MediaController@store')
	->name('media.store')
    ->middleware(['permission:add_media']);

	Route::get('{id}/edit'	,'Admin\MediaController@edit')
	->name('media.edit')
    ->middleware(['permission:edit_media']);

	Route::put('{id}'		,'Admin\MediaController@update')
	->name('media.update')
    ->middleware(['permission:edit_media']);

	Route::delete('{id}'	,'Admin\MediaController@destroy')
	->name('media.destroy')
    ->middleware(['permission:delete_media']);

	Route::get('deletes'	,'Admin\MediaController@deletes')
	->name('media.deletes')
    ->middleware(['permission:delete_media']);

	Route::get('{id}','Admin\MediaController@show')
	->name('media.show')
    ->middleware(['permission:show_media']);
});
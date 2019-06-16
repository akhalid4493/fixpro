<?php

Route::group(['prefix' => 'previews'], function () {

	Route::get('/' ,'Admin\PreviewController@index')
	->name('previews.index')
    ->middleware(['permission:show_previews']);

	Route::get('done' ,'Admin\PreviewController@done')
	->name('previews.done')
    ->middleware(['permission:show_previews']);

	Route::get('datatable'	,'Admin\PreviewController@dataTable')
	->name('previews.dataTable')
    ->middleware(['permission:show_previews']);

	Route::get('{id}/edit'	,'Admin\PreviewController@edit')
	->name('previews.edit')
    ->middleware(['permission:edit_previews']);

	Route::put('{id}'		,'Admin\PreviewController@update')
	->name('previews.update')
    ->middleware(['permission:edit_previews']);

	Route::get('{id}','Admin\PreviewController@show')
	->name('previews.show')
    ->middleware(['permission:show_previews']);
});

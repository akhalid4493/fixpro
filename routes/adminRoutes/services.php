<?php

Route::group(['prefix' => 'services'], function () {

	Route::get('/' ,'Admin\ServiceController@index')
	->name('services.index')
    ->middleware(['permission:show_services']);

	Route::get('re-order', 'Admin\ServiceController@reOrder')
  ->name('services.reOrder')
  ->middleware(['permission:show_services']);

  Route::get('save-re-order', 'Admin\ServiceController@saveReOrder')
  ->name('services.saveReOrder')
  ->middleware(['permission:show_services']);

	Route::get('datatable'	,'Admin\ServiceController@dataTable')
	->name('services.dataTable')
    ->middleware(['permission:show_services']);

	Route::get('create'		,'Admin\ServiceController@create')
	->name('services.create')
    ->middleware(['permission:add_services']);

	Route::post('/'			,'Admin\ServiceController@store')
	->name('services.store')
    ->middleware(['permission:add_services']);

	Route::get('{id}/edit'	,'Admin\ServiceController@edit')
	->name('services.edit')
    ->middleware(['permission:edit_services']);

	Route::put('{id}'		,'Admin\ServiceController@update')
	->name('services.update')
    ->middleware(['permission:edit_services']);

	Route::delete('{id}'	,'Admin\ServiceController@destroy')
	->name('services.destroy')
    ->middleware(['permission:delete_services']);

	Route::get('deletes'	,'Admin\ServiceController@deletes')
	->name('services.deletes')
    ->middleware(['permission:delete_services']);

	Route::get('{id}','Admin\ServiceController@show')
	->name('services.show')
    ->middleware(['permission:show_services']);
});

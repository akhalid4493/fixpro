<?php

Route::group(['prefix' => 'technicals'], function () {

	Route::get('/' ,'Admin\TechnicalController@index')
	->name('technicals.index')
    ->middleware(['permission:show_technicals']);

	Route::get('datatable'	,'Admin\TechnicalController@dataTable')
	->name('technicals.dataTable')
    ->middleware(['permission:show_technicals']);

	Route::get('create'		,'Admin\TechnicalController@create')
	->name('technicals.create')
    ->middleware(['permission:add_technicals']);

	Route::post('/'			,'Admin\TechnicalController@store')
	->name('technicals.store')
    ->middleware(['permission:add_technicals']);

	Route::get('{id}/edit'	,'Admin\TechnicalController@edit')
	->name('technicals.edit')
    ->middleware(['permission:edit_technicals']);

	Route::put('{id}'		,'Admin\TechnicalController@update')
	->name('technicals.update')
    ->middleware(['permission:edit_technicals']);

	Route::delete('{id}'	,'Admin\TechnicalController@destroy')
	->name('technicals.destroy')
    ->middleware(['permission:delete_technicals']);

	Route::get('deletes'	,'Admin\TechnicalController@deletes')
	->name('technicals.deletes')
    ->middleware(['permission:delete_technicals']);

	Route::get('{id}','Admin\TechnicalController@show')
	->name('technicals.show')
    ->middleware(['permission:show_technicals']);
});
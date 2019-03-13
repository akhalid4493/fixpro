<?php

Route::group(['prefix' => 'governorates'], function () {

	Route::get('/' ,'Admin\GovernorateController@index')
	->name('governorates.index')
    ->middleware(['permission:show_governorates']);

	Route::get('datatable'	,'Admin\GovernorateController@dataTable')
	->name('governorates.dataTable')
    ->middleware(['permission:show_governorates']);

	Route::get('create'		,'Admin\GovernorateController@create')
	->name('governorates.create')
    ->middleware(['permission:add_governorates']);

	Route::post('/'			,'Admin\GovernorateController@store')
	->name('governorates.store')
    ->middleware(['permission:add_governorates']);

	Route::get('{id}/edit'	,'Admin\GovernorateController@edit')
	->name('governorates.edit')
    ->middleware(['permission:edit_governorates']);

	Route::put('{id}'		,'Admin\GovernorateController@update')
	->name('governorates.update')
    ->middleware(['permission:edit_governorates']);

	Route::delete('{id}'	,'Admin\GovernorateController@destroy')
	->name('governorates.destroy')
    ->middleware(['permission:delete_governorates']);

	Route::get('deletes'	,'Admin\GovernorateController@deletes')
	->name('governorates.deletes')
    ->middleware(['permission:delete_governorates']);

	Route::get('{id}','Admin\GovernorateController@show')
	->name('governorates.show')
    ->middleware(['permission:show_governorates']);
});
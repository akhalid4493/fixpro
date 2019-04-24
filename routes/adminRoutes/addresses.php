<?php

Route::group(['prefix' => 'addresses'], function () {

	Route::get('/' ,'Admin\AddressController@index')
	->name('addresses.index')
    ->middleware(['permission:show_addresses']);

	Route::get('datatable'	,'Admin\AddressController@dataTable')
	->name('addresses.dataTable')
    ->middleware(['permission:show_addresses']);

	Route::get('create'		,'Admin\AddressController@create')
	->name('addresses.create')
    ->middleware(['permission:add_addresses']);

	Route::post('/'			,'Admin\AddressController@store')
	->name('addresses.store')
    ->middleware(['permission:add_addresses']);

	Route::get('{id}/edit'	,'Admin\AddressController@edit')
	->name('addresses.edit')
    ->middleware(['permission:edit_addresses']);

	Route::put('{id}'		,'Admin\AddressController@update')
	->name('addresses.update')
    ->middleware(['permission:edit_addresses']);

	Route::delete('{id}'	,'Admin\AddressController@destroy')
	->name('addresses.destroy')
    ->middleware(['permission:delete_addresses']);

	Route::get('deletes'	,'Admin\AddressController@deletes')
	->name('addresses.deletes')
    ->middleware(['permission:delete_addresses']);

	Route::get('{id}','Admin\AddressController@show')
	->name('addresses.show')
    ->middleware(['permission:show_addresses']);
});
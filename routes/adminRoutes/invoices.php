<?php

Route::group(['prefix' => 'invoices'], function () {

	Route::get('/' ,'Admin\InvoiceController@index')
	->name('invoices.index')
    ->middleware(['permission:show_invoices']);

	Route::get('datatable'	,'Admin\InvoiceController@dataTable')
	->name('invoices.dataTable')
    ->middleware(['permission:show_invoices']);

	Route::get('create'		,'Admin\InvoiceController@create')
	->name('invoices.create')
    ->middleware(['permission:add_invoices']);

	Route::post('/'			,'Admin\InvoiceController@store')
	->name('invoices.store')
    ->middleware(['permission:add_invoices']);

	Route::get('{id}/edit'	,'Admin\InvoiceController@edit')
	->name('invoices.edit')
    ->middleware(['permission:edit_invoices']);

	Route::put('{id}'		,'Admin\InvoiceController@update')
	->name('invoices.update')
    ->middleware(['permission:edit_invoices']);

	Route::delete('{id}'	,'Admin\InvoiceController@destroy')
	->name('invoices.destroy')
    ->middleware(['permission:delete_invoices']);

	Route::get('deletes'	,'Admin\InvoiceController@deletes')
	->name('invoices.deletes')
    ->middleware(['permission:delete_invoices']);

	Route::get('{id}','Admin\InvoiceController@show')
	->name('invoices.show')
    ->middleware(['permission:show_invoices']);
});
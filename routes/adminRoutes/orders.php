<?php

Route::group(['prefix' => 'orders'], function () {

	Route::get('/' ,'Admin\OrderController@index')
	->name('orders.index')
    ->middleware(['permission:show_orders']);

	Route::get('datatable'	,'Admin\OrderController@dataTable')
	->name('orders.dataTable')
    ->middleware(['permission:show_orders']);

	Route::get('create'		,'Admin\OrderController@create')
	->name('orders.create')
    ->middleware(['permission:add_orders']);

	Route::post('/'			,'Admin\OrderController@store')
	->name('orders.store')
    ->middleware(['permission:add_orders']);

	Route::get('{id}/edit'	,'Admin\OrderController@edit')
	->name('orders.edit')
    ->middleware(['permission:edit_orders']);

	Route::put('{id}'		,'Admin\OrderController@update')
	->name('orders.update')
    ->middleware(['permission:edit_orders']);

	Route::delete('{id}'	,'Admin\OrderController@destroy')
	->name('orders.destroy')
    ->middleware(['permission:delete_orders']);

	Route::get('deletes'	,'Admin\OrderController@deletes')
	->name('orders.deletes')
    ->middleware(['permission:delete_orders']);

	Route::get('{id}','Admin\OrderController@show')
	->name('orders.show')
    ->middleware(['permission:show_orders']);
});

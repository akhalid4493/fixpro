<?php

Route::group(['prefix' => 'products'], function () {

	Route::get('/' ,'Admin\ProductController@index')
	->name('products.index')
    ->middleware(['permission:show_products']);

	Route::get('datatable'	,'Admin\ProductController@dataTable')
	->name('products.dataTable')
    ->middleware(['permission:show_products']);

	Route::get('create'		,'Admin\ProductController@create')
	->name('products.create')
    ->middleware(['permission:add_products']);

	Route::post('/'			,'Admin\ProductController@store')
	->name('products.store')
    ->middleware(['permission:add_products']);

	Route::get('{id}/edit'	,'Admin\ProductController@edit')
	->name('products.edit')
    ->middleware(['permission:edit_products']);

	Route::put('{id}'		,'Admin\ProductController@update')
	->name('products.update')
    ->middleware(['permission:edit_products']);

	Route::delete('{id}'	,'Admin\ProductController@destroy')
	->name('products.destroy')
    ->middleware(['permission:delete_products']);

	Route::get('deletes'	,'Admin\ProductController@deletes')
	->name('products.deletes')
    ->middleware(['permission:delete_products']);

	Route::get('{id}','Admin\ProductController@show')
	->name('products.show')
    ->middleware(['permission:show_products']);
});
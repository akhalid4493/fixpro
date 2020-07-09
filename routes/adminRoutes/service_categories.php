<?php

Route::group(['prefix' => 'service_categories'], function () {

	Route::get('/' ,'Admin\ServiceCategoryController@index')
	->name('service_categories.index')
    ->middleware(['permission:show_service_categories']);

	Route::get('datatable'	,'Admin\ServiceCategoryController@dataTable')
	->name('service_categories.dataTable')
    ->middleware(['permission:show_service_categories']);

	Route::get('create'		,'Admin\ServiceCategoryController@create')
	->name('service_categories.create')
    ->middleware(['permission:add_service_categories']);

	Route::post('/'			,'Admin\ServiceCategoryController@store')
	->name('service_categories.store')
    ->middleware(['permission:add_service_categories']);

	Route::get('{id}/edit'	,'Admin\ServiceCategoryController@edit')
	->name('service_categories.edit')
    ->middleware(['permission:edit_service_categories']);

	Route::put('{id}'		,'Admin\ServiceCategoryController@update')
	->name('service_categories.update')
    ->middleware(['permission:edit_service_categories']);

	Route::delete('{id}'	,'Admin\ServiceCategoryController@destroy')
	->name('service_categories.destroy')
    ->middleware(['permission:delete_service_categories']);

	Route::get('deletes'	,'Admin\ServiceCategoryController@deletes')
	->name('service_categories.deletes')
    ->middleware(['permission:delete_service_categories']);

	Route::get('{id}','Admin\ServiceCategoryController@show')
	->name('service_categories.show')
    ->middleware(['permission:show_service_categories']);
});

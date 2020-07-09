<?php

Route::group(['prefix' => 'ads'], function () {

	Route::get('/' ,'Admin\AdsController@index')
	->name('ads.index')
    ->middleware(['permission:show_ads']);

	Route::get('datatable'	,'Admin\AdsController@dataTable')
	->name('ads.dataTable')
    ->middleware(['permission:show_ads']);

	Route::get('create'		,'Admin\AdsController@create')
	->name('ads.create')
    ->middleware(['permission:add_ads']);

	Route::post('/'			,'Admin\AdsController@store')
	->name('ads.store')
    ->middleware(['permission:add_ads']);

	Route::get('{id}/edit'	,'Admin\AdsController@edit')
	->name('ads.edit')
    ->middleware(['permission:edit_ads']);

	Route::put('{id}'		,'Admin\AdsController@update')
	->name('ads.update')
    ->middleware(['permission:edit_ads']);

	Route::delete('{id}'	,'Admin\AdsController@destroy')
	->name('ads.destroy')
    ->middleware(['permission:delete_ads']);

	Route::get('deletes'	,'Admin\AdsController@deletes')
	->name('ads.deletes')
    ->middleware(['permission:delete_ads']);

	Route::get('{id}','Admin\AdsController@show')
	->name('ads.show')
    ->middleware(['permission:show_ads']);
});

<?php

Route::group(['prefix' => 'subscriptions'], function () {

	Route::get('/' ,'Admin\SubscriptionController@index')
	->name('subscriptions.index')
    ->middleware(['permission:show_subscriptions']);

	Route::get('datatable'	,'Admin\SubscriptionController@dataTable')
	->name('subscriptions.dataTable')
    ->middleware(['permission:show_subscriptions']);

	Route::get('create'		,'Admin\SubscriptionController@create')
	->name('subscriptions.create')
    ->middleware(['permission:add_subscriptions']);

	Route::post('/'			,'Admin\SubscriptionController@store')
	->name('subscriptions.store')
    ->middleware(['permission:add_subscriptions']);

	Route::get('{id}/edit'	,'Admin\SubscriptionController@edit')
	->name('subscriptions.edit')
    ->middleware(['permission:edit_subscriptions']);

	Route::put('{id}'		,'Admin\SubscriptionController@update')
	->name('subscriptions.update')
    ->middleware(['permission:edit_subscriptions']);

	Route::delete('{id}'	,'Admin\SubscriptionController@destroy')
	->name('subscriptions.destroy')
    ->middleware(['permission:delete_subscriptions']);

	Route::get('deletes'	,'Admin\SubscriptionController@deletes')
	->name('subscriptions.deletes')
    ->middleware(['permission:delete_subscriptions']);

	Route::get('{id}','Admin\SubscriptionController@show')
	->name('subscriptions.show')
    ->middleware(['permission:show_subscriptions']);
});
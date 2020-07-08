<?php
Route::group([ 'prefix' => LaravelLocalization::setLocale() ,'middleware' =>
			 [ 'localizationRedirect', 'localeSessionRedirect']],function(){

	/*
    |================================================================================
    |                             BACKEND ROUTES
    |================================================================================
    */

    Route::prefix('dashboard')->middleware(['auth','permission:admin_dashboard'])->group(function () {

        Route::get('/' ,'Admin\AdminController@index')->name('admin');
				Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

        foreach (File::allFiles(base_path('routes/adminRoutes')) as $file) {
            require_once($file->getPathname());
        }

    });


	/*
    |================================================================================
    |                            FRONTEND ROUTES
    |================================================================================
    */

    Auth::routes();

    Route::get('/'  ,'Front\FrontController@index')->name('home');

    // PAYMENT API -- SUCCESS OR FAIELD
    Route::get('success','Payment\OrderPaymentController@success')->name('ApiSuccess');
    Route::get('failed' ,'Payment\OrderPaymentController@error')->name('ApiFailed');

    Route::get('subscription/success','Payment\SubscriptionPaymentController@success')->name('SubscribeSuccess');
    Route::get('subscription/failed' ,'Payment\SubscriptionPaymentController@error')->name('SubscribeFailed');

});

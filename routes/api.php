<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1','middleware' => ['localization','api'] ],function(){
	
	foreach (File::allFiles(base_path('routes/apiRoutes')) as $file) {
        require_once($file->getPathname());
    }
    
	// // GLOBAL API ROUTES
	// Route::get('settings'         , 'Api\UserApp\GlobalController@settings');
	// Route::get('setting'          , 'Api\UserApp\GlobalController@setting');
	// Route::get('pages'            , 'Api\UserApp\GlobalController@allPages');
	// Route::get('page/{id}'        , 'Api\UserApp\GlobalController@page');
	// Route::post('contactus'       , 'Api\UserApp\ApiController@contactus');

	// // USER API ROUTES
	// Route::post('register'        , 'Api\UserApp\UserController@register');
	// Route::post('login'           , 'Api\UserApp\UserController@login');
	// Route::post('forget/password' , 'Api\UserApp\UserController@__invoke');
	// Route::post('profile'         , 'Api\UserApp\UserController@profile');
	// Route::post('update-user'     , 'Api\UserApp\UserController@updateProfile');
	// Route::post('update-pic'      , 'Api\UserApp\UserController@updatePic');
	// Route::post('change-password' , 'Api\UserApp\UserController@changePassword');
	// Route::post('check_token'     , 'Api\UserApp\UserController@checkToken');
	// Route::post('update_device_id', 'Api\UserApp\UserController@updateDeviceId');
	// Route::post('device_token'    , 'Api\UserApp\UserController@deviceToken');

	// // ADDRESS API ROUTES
	// Route::get('governorates'     , 'Api\UserApp\GlobalController@governorates');
	// Route::get('provinces'        , 'Api\UserApp\GlobalController@provinces');
	// Route::post('add_address'     , 'Api\UserApp\UserController@address');
	// Route::post('get_address'     , 'Api\UserApp\UserController@getAddress');
	// Route::post('update_address'  , 'Api\UserApp\UserController@updateAddress');

	// // PREVIEW
	// Route::get('services'         , 'Api\UserApp\PreviewController@services');
	// Route::post('make_preview'    , 'Api\UserApp\PreviewController@makePreview');
	// Route::post('my_previews'     , 'Api\UserApp\PreviewController@myPreviews');
	// Route::post('my_preview/{id}' , 'Api\UserApp\PreviewController@myPreview');

	// // STORE API ROUTES
	// Route::post('my_orders'       , 'Api\UserApp\StoreController@myOrders');
	// Route::post('my_order/{id}'   , 'Api\UserApp\StoreController@getOrder');
	// Route::post('order_action'    , 'Api\UserApp\StoreController@orderAction');
	
	// // PACKAGES API ROUTES
	// Route::post('my_packages'     , 'Api\UserApp\PackageController@myPackages');
	// Route::post('my_package/{id}' , 'Api\UserApp\PackageController@getPackage');
	// Route::post('subscription'    , 'Api\UserApp\PackageController@subscription');


	// // PAYMENT API -- SUCCESS OR FAIELD
	// Route::get('success','Payment\OrderPaymentController@success')->name('ApiSuccess');
	// Route::get('failed' ,'Payment\OrderPaymentController@error')->name('ApiFailed');

});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

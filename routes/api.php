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

	foreach (File::allFiles(base_path('routes/apiRoutes/v1/user')) as $file) {
        require_once($file->getPathname());
    }

});

Route::group(['prefix' => 'v2','middleware' => ['localization','api'] ],function(){

	foreach (File::allFiles(base_path('routes/apiRoutes/v2/user')) as $file) {
        require_once($file->getPathname());
    }

});

Route::group(['prefix' => 'v1/technical','middleware' => ['localization','api'] ],function(){

	foreach (File::allFiles(base_path('routes/apiRoutes/v1/technical')) as $file) {
        require_once($file->getPathname());
    }

});

Route::group(['prefix' => 'v2/technical','middleware' => ['localization','api'] ],function(){

	foreach (File::allFiles(base_path('routes/apiRoutes/v2/technical')) as $file) {
        require_once($file->getPathname());
    }

});

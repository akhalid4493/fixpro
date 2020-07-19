<?php

Route::group(['prefix' => 'timezone'], function () {

	Route::get('/' 	,function () {

			return response()->json([
						'data'   		=> [
							'time'		=> new \Carbon\Carbon,
						],
						'successfully'	=> true,
            'errors' 		=> false,
        ],200);

	});

});

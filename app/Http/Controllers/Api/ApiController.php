<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactUs;
use Mail;

class ApiController extends Controller
{
	public function index(Request $request)
	{
		return view('errors.404');
	}

	public function responseMessages($data=[], $status=false,$code=404,$errors=[])
	{
			return response()->json([
						'data'   		=> $data,
						'successfully'	=> $status,
	          'errors' 		=> $errors,
	    ],$code);
	}
}

<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\CustomClass\PreviewCheck;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function index()
    {
        //return PreviewCheck::getPreviews(8,4);
    	return view('admin.home');
    }
}

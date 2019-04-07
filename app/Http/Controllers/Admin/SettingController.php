<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\TheApp\Libraries\SettingRepository;
use App\TheApp\Requests\Admin\Settings\SettingRequest;
use Settings;

class SettingController extends AdminController
{

    public function index()
    {        
        return view('admin.settings.all');
    }


    public function dataTable(Request $request)
    {

    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $settings = Settings::updateSettings($request->except('_token'));
        
        return $settings;
    }


    public function show($id)
    {
        
    }


    public function edit($id)
    {
        
    }


    public function update(Request $request, $id)
    {
        
    }


    public function destroy($id)
    {
        
    }

}

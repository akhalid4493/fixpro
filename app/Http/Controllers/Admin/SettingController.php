<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Requests\Admin\Settings\SettingRequest;
use App\TheApp\Libraries\SettingRepository;
use Illuminate\Http\Request;
use Settings;

class SettingController extends AdminController
{

    public function index()
    {
        return view('admin.settings.all');
    }

    public function service_notifications()
    {
        return view('admin.notifications.service_notifications');
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

    public function storeServiceNotification(Request $request)
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

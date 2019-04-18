<?php

namespace App\Http\Controllers\Admin;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityController extends AdminController
{
    public function index()
    {
        $activities =  Activity::where('read_at',null)->orderBy('id','DESC')->limit(6)->get();
    	$counter    =  Activity::where('read_at',null)
                        ->where('created_at','>', Carbon::now()->subMinutes(5)->toDateTimeString())
                        ->count();

        $view = view('admin.activities.alert',compact('activities'));

        $data = array(
            'view'                  => $view->render(),
            'unseen_notification'   => $counter
        );

        return $data;
    }

    public function update()
    {
    	return Activity::where('read_at',null)->update(['read_at'=>Carbon::now()]);
    }
}

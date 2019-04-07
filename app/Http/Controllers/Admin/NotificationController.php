<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\TheApp\Libraries\SendNotification;
use App\TheApp\Repository\Admin\Users\UserRepository;

class NotificationController extends AdminController
{
	use SendNotification;

    public function __construct(UserRepository $user)
    {
        $this->userModel = $user;
    }

    public function notifyForm()
    {
        return view('admin.notifications.create');
    }

    public  function push_notification(Request $request) 
    {
        $tokens = $this->userModel->getAllTokens();

        $data = [
            'title' => $request['title'],
            'body'  => $request['body']
        ];

      	$this->send($data,$tokens);
     
        return back()->with(['msg'=>'Notification Send Successfully' , 'alert'=>'success']);
    }
}

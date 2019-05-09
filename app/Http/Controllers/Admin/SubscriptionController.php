<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Subscriptions\SubscriptionRepository as Subscription;
use App\TheApp\Repository\Admin\Packages\PackageRepository as Package;
use App\TheApp\Repository\Admin\Users\UserRepository as User;
use Illuminate\Http\Request;
use Response;
use DB;

class SubscriptionController extends AdminController
{

    function __construct(Subscription $subscription,Package $package ,User $user )
    {
        $this->subscriptionModel = $subscription;
        $this->packageModel      = $package;
        $this->userModel         = $user;
    }


    public function index()
    {
        return view('admin.subscriptions.home');
    }


    public function dataTable(Request $request)
    {
        return $this->subscriptionModel->dataTable($request);
    }


    public function create()
    {
        $packages   = $this->packageModel->getAll();
        $users      = $this->userModel->UsersOnly();

        return view('admin.subscriptions.create',compact('users','packages'));
    }


    public function store(Request $request)
    {
        $create = $this->subscriptionModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $subscription = $this->subscriptionModel->findById($id);

        if (!$subscription)
            abort(404);

        return view('admin.subscriptions.show' , compact('subscription'));
    }


    public function edit($id)
    {
        $subscription   = $this->subscriptionModel->findById($id);
        $packages       = $this->packageModel->getAll();
        $users          = $this->userModel->UsersOnly();

        if (!$subscription)
            abort(404);

        return view('admin.subscriptions.edit',compact('subscription','packages','users'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->subscriptionModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->subscriptionModel->delete($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $repose = $this->subscriptionModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

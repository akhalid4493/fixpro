<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Subscriptions\SubscriptionRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class SubscriptionController extends AdminController
{

    function __construct(SubscriptionRepository $subscription)
    {
        $this->subscriptionModel = $subscription;
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
        return view('admin.subscriptions.create');
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
        $statuses   = $this->subscriptionModel->getAllStatus();

        if (!$subscription)
            abort(404);

        return view('admin.subscriptions.show' , compact('subscription','statuses'));
    }


    public function edit($id)
    {
        $subscription   = $this->subscriptionModel->findById($id);

        if (!$subscription)
            abort(404);

        return view('admin.subscriptions.edit',compact('subscription'));
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

}

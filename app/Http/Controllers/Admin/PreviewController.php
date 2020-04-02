<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Previews\PreviewRepository;
use App\TheApp\Repository\Admin\Services\ServiceRepository;
use App\TheApp\Requests\Admin\Previews\NewPreviewRequest;
use App\TheApp\Repository\Admin\Users\UserRepository;
use Illuminate\Http\Request;
use Response;
use Preview;
use DB;

class PreviewController extends AdminController
{

    function __construct(PreviewRepository $preview,UserRepository $user,ServiceRepository $service)
    {
        $this->previewModel = $preview;
        $this->userModel = $user;
        $this->serviceModel = $service;
    }


    public function index()
    {
        $services  = $this->serviceModel->getAll();
        return view('admin.previews.home',compact('services'));
    }

    public function done()
    {
        $services  = $this->serviceModel->getAll();
        return view('admin.previews.done',compact('services'));
    }

    public function cancelled()
    {
        $services  = $this->serviceModel->getAll();
        return view('admin.previews.cancelled',compact('services'));
    }

    public function dataTable(Request $request)
    {
        return $this->previewModel->dataTable($request);
    }

    public function create()
    {
        $services  = $this->serviceModel->getAll();
        $users  = $this->userModel->getAll();
        return view('admin.previews.create',compact('users','services'));
    }

    public function store(NewPreviewRequest $request)
    {
            $create = $this->previewModel->create($request);

            if($create)
                return Response()->json([true , 'تم الاضافة بنجاح' ]);

            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $preview    = $this->previewModel->findById($id);
        // return Preview::technicalOfService($preview);
        $statuses   = $this->previewModel->getAllStatus();
        $users      = $this->userModel->TechnicalUsers();

        if (!$preview)
            abort(404);

        return view('admin.previews.show' , compact('preview','statuses','users'));
    }


    public function edit($id)
    {
        $preview   = $this->previewModel->findById($id);

        if (!$preview)
            abort(404);

        return view('admin.previews.edit',compact('preview'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->previewModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->previewModel->delete($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }


    public function userAddresses(Request $request)
    {
        $user = $this->userModel->findById($request['id']);
        $addresses = $user->address;

        return view('admin.previews.parts.addresses')->with([ 'addresses' => $addresses ]);
    }

}

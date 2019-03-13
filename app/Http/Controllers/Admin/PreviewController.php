<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Previews\PreviewRepository;
use App\TheApp\Repository\Admin\Users\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use DB;

class PreviewController extends AdminController
{

    function __construct(PreviewRepository $preview,UserRepository $user)
    {
        $this->previewModel = $preview;
        $this->userModel = $user;

        // PERMISSION OF ADMIN FUNCTIONS
        $this->middleware('permission:show_previews'  ,['only' => ['show'   , 'index']]);
        $this->middleware('permission:add_previews'   ,['only' => ['create' , 'store']]);
        $this->middleware('permission:edit_previews'  ,['only' => ['edit'   , 'update']]);
        $this->middleware('permission:delete_previews',['only' => ['destroy']]);
    }


    public function index()
    {
        return view('admin.previews.home');
    }


    public function dataTable(Request $request)
    {
        return $this->previewModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.previews.create');
    }


    public function store(Request $request)
    {
            $create = $this->previewModel->create($request);

            if($create)
                return Response()->json([true , 'تم الاضافة بنجاح' ]);
            
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $preview = $this->previewModel->findById($id);
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

}

<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Installation\InstallationRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class InstallationController extends AdminController
{

    function __construct(InstallationRepository $installation)
    {
        $this->installationModel  = $installation;
    }


    public function index()
    {
        return view('admin.installations.home');
    }


    public function dataTable(Request $request)
    {
        return $this->installationModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.installations.create');
    }


    public function store(Request $request)
    {
        $create = $this->installationModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $installation = $this->installationModel->findById($id);
        
        if (!$installation)
            abort(404);

        return view('admin.installations.show' , compact('installation'));
    }


    public function edit($id)
    {
        $installation    = $this->installationModel->findById($id);

        if (!$installation)
            abort(404);

        return view('admin.installations.edit',compact('installation'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->installationModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->installationModel->delete($id);

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
            $repose = $this->installationModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

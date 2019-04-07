<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Services\ServiceRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class ServiceController extends AdminController
{

    function __construct(ServiceRepository $service)
    {
        $this->serviceModel = $service;
    }


    public function index()
    {
        return view('admin.services.home');
    }


    public function dataTable(Request $request)
    {
        return $this->serviceModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.services.create');
    }


    public function store(Request $request)
    {
            $create = $this->serviceModel->create($request);

            if($create)
                return Response()->json([true , 'تم الاضافة بنجاح' ]);
            
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $service = $this->serviceModel->findById($id);
        
        if (!$service)
            abort(404);

        return view('admin.services.show' , compact('service'));
    }


    public function edit($id)
    {
        $service   = $this->serviceModel->findById($id);

        if (!$service)
            abort(404);

        return view('admin.services.edit',compact('service'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->serviceModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->serviceModel->delete($id);

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
            $repose = $this->serviceModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

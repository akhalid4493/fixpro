<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TheApp\Repository\Admin\Governorates\GovernorateRepository;

class GovernorateController extends AdminController
{

    function __construct(GovernorateRepository $governorate)
    {
        $this->governorateModel = $governorate;
    }


    public function index()
    {
        return view('admin.governorates.home');
    }


    public function dataTable(Request $request)
    {
        return $this->governorateModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.governorates.create');
    }


    public function store(Request $request)
    {
        $create = $this->governorateModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $governorate = $this->governorateModel->findById($id);
        
        if (!$governorate)
            abort(404);

        return view('admin.governorates.show' , compact('governorate'));
    }


    public function edit($id)
    {
        $governorate   = $this->governorateModel->findById($id);

        if (!$governorate)
            abort(404);

        return view('admin.governorates.edit',compact('governorate'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->governorateModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->governorateModel->delete($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\TheApp\Repository\Admin\Provinces\ProvinceRepository;
use App\TheApp\Repository\Admin\Governorates\GovernorateRepository;

class ProvinceController extends AdminController
{

    function __construct(ProvinceRepository $province,GovernorateRepository $governorate)
    {
        $this->provinceModel    = $province;
        $this->governorateModel = $governorate;
    }

    public function index()
    {
        return view('admin.provinces.home');
    }

    public function getByGovernorates(Request $request)
    {
        $provinces = $this->provinceModel->getByGovernorates($request['governorate_id']);
        return view('admin.nurseries.parts.provinces',compact('provinces'));
    }

    public function dataTable(Request $request)
    {
        return $this->provinceModel->dataTable($request);
    }


    public function create()
    {
        $governorates = $this->governorateModel->getAll();

        return view('admin.provinces.create' , compact('governorates'));
    }

    public function store(Request $request)
    {
        $create = $this->provinceModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }

    public function show($id)
    {
        $province = $this->provinceModel->findById($id);
        
        if (!$province)
            abort(404);

        return view('admin.provinces.show' , compact('province'));
    }


    public function edit($id)
    {
        $governorates   = $this->governorateModel->getAll();
        $province       = $this->provinceModel->findById($id);

        if (!$province)
            abort(404);

        return view('admin.provinces.edit',compact('province','governorates'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->provinceModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->provinceModel->delete($id);

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
            $repose = $this->provinceModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

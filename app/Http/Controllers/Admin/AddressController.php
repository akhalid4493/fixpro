<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Addresses\AddressRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class AddressController extends AdminController
{

    function __construct(AddressRepository $address)
    {
        $this->addressModel = $address;
    }


    public function index()
    {
        return view('admin.addresses.home');
    }


    public function dataTable(Request $request)
    {
        return $this->addressModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.addresses.create');
    }


    public function store(Request $request)
    {
            $create = $this->addressModel->create($request);

            if($create)
                return Response()->json([true , 'تم الاضافة بنجاح' ]);
            
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $address = $this->addressModel->findById($id);
        
        if (!$address)
            abort(404);

        return view('admin.addresses.show' , compact('address'));
    }


    public function edit($id)
    {
        $address   = $this->addressModel->findById($id);

        if (!$address)
            abort(404);

        return view('admin.addresses.edit',compact('address'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->addressModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->addressModel->delete($id);

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
            $repose = $this->addressModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

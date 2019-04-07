<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\TheApp\Repository\Admin\Users\UserRepository;
use App\TheApp\Repository\Admin\Packages\PackageRepository;

class PackageController extends AdminController
{

    function __construct(PackageRepository $package,UserRepository $user)
    {
        $this->packageModel = $package;
        $this->userModel = $user;
    }


    public function index()
    {
        return view('admin.packages.home');
    }


    public function dataTable(Request $request)
    {
        return $this->packageModel->dataTable($request);
    }


    public function create()
    {
        $users = $this->userModel->getAll();
        return view('admin.packages.create',compact('users'));
    }


    public function store(Request $request)
    {
        $create = $this->packageModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $package = $this->packageModel->findById($id);
        
        if (!$package)
            abort(404);

        return view('admin.packages.show' , compact('package'));
    }


    public function edit($id)
    {
        $package   = $this->packageModel->findById($id);
        $users = $this->userModel->getAll();
        // $users     = $this->userModel->UsersOnly();

        if (!$package)
            abort(404);

        return view('admin.packages.edit',compact('package','users'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->packageModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->packageModel->delete($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

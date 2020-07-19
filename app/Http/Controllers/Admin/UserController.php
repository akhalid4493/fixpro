<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Governorates\GovernorateRepository;
use App\TheApp\Repository\Admin\Users\UserRepository;
use App\TheApp\Repository\Admin\Roles\RoleRepository;
use App\TheApp\Requests\Admin\Users\EditUserRequest;
use App\TheApp\Requests\Admin\Users\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use DB;

class UserController extends AdminController
{

    function __construct(UserRepository $user, RoleRepository $role,GovernorateRepository $governorate)
    {
        $this->userModel        = $user;
        $this->roleModel        = $role;
        $this->governorateModel = $governorate;
    }


    public function index()
    {
        $roles   = $this->roleModel->getAll();

        return view('admin.users.home',compact('roles'));
    }


    public function dataTable(Request $request)
    {
        return $this->userModel->dataTable($request);
    }


    public function create()
    {
        $roles      = $this->roleModel->getAll();
        return view('admin.users.create',compact('roles'));
    }


    public function store(UserRequest $request)
    {
        if ($request->ajax()){
            $create = $this->userModel->create($request);

            if($create)
                return Response()->json([true , 'تم الاضافة بنجاح' ]);

            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function show($id)
    {
        $governorates = $this->governorateModel->getAll();

        $user = $this->userModel->findById($id);

        if (!$user)
            abort(404);

        return view('admin.users.show' , compact('user','governorates'));
    }


    public function edit($id)
    {
        $roles = $this->roleModel->getAll();
        $user  = $this->userModel->findById($id);

        if (!$user)
            abort(404);

        $admin_roles = $user->roles()->pluck('id')->toArray();

        return view('admin.users.edit',compact('user','admin_roles','roles'));
    }


    public function update(EditUserRequest $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->userModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }

    public function destroy($id)
    {
        try {

            $repose = $this->userModel->delete($id);

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
            $repose = $this->userModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Permissions\PermsReopository as Permission;
use App\TheApp\Repository\Admin\Roles\RoleRepository as Role;
use Illuminate\Http\Request;

class RolesController extends AdminController
{
    function __construct(Role $role ,Permission $permission)
    {
        $this->permissionModel  = $permission;
        $this->roleModel        = $role;
    }

    public function index()
    {
        return view('admin.roles.home');
    }

    public function dataTable(Request $request)
    {
        return $this->roleModel->dataTable($request);
    }

    public function create()
    {
        $perms = $this->permissionModel->getAll('id','asc');
        return view('admin.roles.create',compact('perms'));
    }

    public function store(Request $request)
    {
        $create = $this->roleModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $role = $this->roleModel->findById($id);

        if (!$role)
            abort(404);

        return view('admin.roles.show' , compact('role'));
    }

    public function edit($id)
    {
        $perms = $this->permissionModel->getAll('id','asc');
        $role  = $this->roleModel->findById($id);
        
        if (!$role)
            return abort(404);

        $role_perms = $role->perms()->pluck('id')->toArray();
        return view('admin.roles.edit' , compact('role' , 'perms' , 'role_perms'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()){
            $update = $this->roleModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }

    public function destroy($id)
    {
        try {
            $repose = $this->roleModel->delete($id);

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
            $repose = $this->roleModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
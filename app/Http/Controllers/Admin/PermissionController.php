<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Permissions\PermsReopository as Permission;
use Illuminate\Http\Request;

class PermissionController extends AdminController
{
    function __construct(Permission $permission)
    {
        $this->permissionModel = $permission;
    }

    public function index()
    {
        return view('admin.permissions.home');
    }

    public function dataTable(Request $request)
    {
        return $this->permissionModel->dataTable($request);
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $create = $this->permissionModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $ad = $this->adModel->findById($id);

        if (!$ad)
            abort(404);

        return view('admin.ads.gallery' , compact('ad'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function deletes(Request $request)
    {
        try {
            
            $repose = $this->permissionModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }

            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
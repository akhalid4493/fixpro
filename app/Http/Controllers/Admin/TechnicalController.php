<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Governorates\GovernorateRepository as Governorate;
use App\TheApp\Repository\Admin\Users\TechncialRepository as Technical;
use App\TheApp\Repository\Admin\Services\ServiceRepository as Service;
use App\TheApp\Repository\Admin\Categories\CategoryRepository as Category;
use App\TheApp\Repository\Admin\Roles\RoleRepository as Role;
use App\TheApp\Requests\Admin\Users\EditUserRequest;
use App\TheApp\Requests\Admin\Users\UserRequest;
use Illuminate\Http\Request;
use Response;
use DB;

class TechnicalController extends AdminController
{

    function __construct(
      Technical $user,
      Role $role,
      Governorate $governorate,
      Service $service,
      Category $category
    )
    {
        $this->userModel        = $user;
        $this->roleModel        = $role;
        $this->serviceModel     = $service;
        $this->governorateModel = $governorate;
        $this->categoryModel    = $category;
    }


    public function index()
    {
        $roles   = $this->roleModel->getAll();

        return view('admin.technicals.home',compact('roles'));
    }


    public function dataTable(Request $request)
    {
        if ($request->ajax())
            return $this->userModel->dataTable($request);
    }

    public function show($id)
    {
        $user = $this->userModel->findById($id);

        if (!$user)
            abort(404);

        return view('admin.technicals.show' , compact('user'));
    }


    public function edit($id)
    {
        $user   = $this->userModel->findById($id);

        if (!$user)
            abort(404);

        $categories     = $this->categoryModel->getAll();
        $governorates   = $this->governorateModel->getAll();
        $services       = $this->serviceModel->getAll();
        $roles          = $this->roleModel->getAll();
        $admin_roles    = $user->roles()->pluck('id')->toArray();

        return view('admin.technicals.edit',
               compact('user','admin_roles','roles','governorates','services','categories'));
    }


    public function update(Request $request, $id)
    {
        $update = $this->userModel->update($request , $id);

        if($update){
            return Response()->json([true , 'تم التعديل بنجاح']);
        }
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);
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

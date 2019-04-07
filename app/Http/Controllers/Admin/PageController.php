<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Pages\PageRepository;
use App\TheApp\Requests\Admin\Pages\EditPageRequest;
use App\TheApp\Requests\Admin\Pages\PageRequest;
use Illuminate\Http\Request;
use Response;
use DB;

class PageController extends AdminController
{

    function __construct(PageRepository $page)
    {
        $this->pageModel = $page;
    }


    public function index()
    {        
        return view('admin.pages.home');
    }


    public function dataTable(Request $request)
    {
        return $this->pageModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.pages.create');
    }


    public function store(Request $request)
    {
        if ($request->ajax()){
            $create = $this->pageModel->create($request);

            if($create)
                return Response()->json([true , 'تم الاضافة بنجاح' ]);
            
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function show($id)
    {
        $page = $this->pageModel->findById($id);
        
        if (!$page)
            abort(404);

        return view('admin.pages.show' , compact('page'));
    }


    public function edit($id)
    {
        $page  = $this->pageModel->findById($id);

        if (!$page)
            abort(404);

        return view('admin.pages.edit',compact('page'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->pageModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->pageModel->delete($id);

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
            $repose = $this->pageModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Ads\AdsRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class AdsController extends AdminController
{

    function __construct(AdsRepository $ads)
    {
        $this->adsModel  = $ads;
    }


    public function index()
    {
        return view('admin.ads.home');
    }


    public function dataTable(Request $request)
    {
        return $this->adsModel->dataTable($request);
    }


    public function create()
    {
        return view('admin.ads.create');
    }


    public function store(Request $request)
    {
        $create = $this->adsModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);

        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $ads = $this->adsModel->findById($id);

        if (!$ads)
            abort(404);

        return view('admin.ads.show' , compact('ads'));
    }


    public function edit($id)
    {
        $ads    = $this->adsModel->findById($id);

        if (!$ads)
            abort(404);

        return view('admin.ads.edit',compact('ads'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->adsModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->adsModel->delete($id);

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
            $repose = $this->adsModel->deleteAll($request);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

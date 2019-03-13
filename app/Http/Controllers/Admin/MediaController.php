<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Media\MediaRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use DB;

class MediaController extends AdminController
{

    function __construct(MediaRepository $media)
    {
        $this->mediaModel     = $media;
    }


    public function index()
    {
        return view('admin.media.gallery');
    }


    public function dataTable(Request $request)
    {
        return $this->mediaModel->gallaryDataTable($request);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $create = $this->mediaModel->createGallery($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);
        
        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $media = $this->mediaModel->findById($id);

        if (!$media)
            abort(404);

        return view('admin.media.gallery' , compact('media'));
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
        
    }


    public function destroy($id)
    {
        try {

            $repose = $this->mediaModel->deleteGallary($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

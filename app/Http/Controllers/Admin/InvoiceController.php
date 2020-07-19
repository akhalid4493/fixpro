<?php

namespace App\Http\Controllers\Admin;

use App\TheApp\Repository\Admin\Invoices\InvoiceRepository as Invoice;
use Illuminate\Http\Request;
use Response;
use DB;

class InvoiceController extends AdminController
{

    function __construct(Invoice $invoice)
    {
        $this->invoiceModel = $invoice;
    }


    public function index()
    {
        return view('admin.invoices.home');
    }


    public function dataTable(Request $request)
    {
        return $this->invoiceModel->dataTable($request);
    }


    public function create()
    {

        return view('admin.invoices.create');
    }


    public function store(Request $request)
    {
        $create = $this->invoiceModel->create($request);

        if($create)
            return Response()->json([true , 'تم الاضافة بنجاح' ]);

        return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

    }


    public function show($id)
    {
        $invoice = $this->invoiceModel->findById($id);

        if (!$invoice)
            abort(404);

        return view('admin.invoices.show' , compact('invoice'));
    }


    public function edit($id)
    {
        $invoice   = $this->invoiceModel->findById($id);

        if (!$invoice)
            abort(404);

        return view('admin.invoices.edit',compact('invoice'));
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $update = $this->invoiceModel->update($request , $id);

            if($update){
                return Response()->json([true , 'تم التعديل بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }
    }


    public function destroy($id)
    {
        try {

            $repose = $this->invoiceModel->delete($id);

            if($repose){
                return Response()->json([true, 'تم الحذف بنجاح']);
            }
            return Response()->json([false  , 'حدث خطا ، حاول مره اخرى']);

        }catch (\PDOException $e){
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

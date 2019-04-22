<?php
namespace App\TheApp\Repository\Admin\Invoices;

use App\Models\SubscriptionMonthly;
use Auth;
use DB;

class InvoiceRepository
{
    protected $model;

    function __construct(SubscriptionMonthly $monthly)
    {
        $this->model = $monthly;
    }

    public function monthlyProfite()
    {
        $data["profit_dates"] = $this->model
                                ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
                                ->groupBy('date')
                                ->pluck('date');

        $profits = $this->model
                    ->select(\DB::raw("sum(total) as profit"))
                    ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                    ->get();

        $data["profits"] = json_encode(array_pluck($profits, 'profit'));

        return $data;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function dataTable($request)
    {
        $sort['col'] = $request->input('columns.' . $request->input('order.0.column') . '.data');    
        $sort['dir'] = $request->input('order.0.dir');
        $search      = $request->input('search.value');

        // Search Query
        $query = $this->filter($request,$search);

        $output['recordsTotal']    = $query->count();
        $output['recordsFiltered'] = $query->count();
        $output['draw']            = intval($request->input('draw'));

        // Get Data
        $invoices = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($invoices))
        {
            foreach ($invoices as $invoice)
            {
                $id = $invoice['id'];

                $edit   = btn('edit'  ,'edit_invoices'  ,url(route('invoices.edit',$id)));
                $show   = btn('show','show_invoices' ,url(route('invoices.show',$id)));

                $obj['id']               = $invoice->id;
                $obj['subscription_id']  = '#'.$invoice->subscription->id;
                $obj['user_name']        = $invoice->subscription->user->name;
                $obj['price']            = Price($invoice->price);
                $obj['paid_at']          = $invoice->paid_at;
                $obj['listBox']          = checkBoxDelete($id);
                $obj['options']          = $show;
                
                $data[] = $obj;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->model->where(function($query) use($search) {
                    $query->where('id'                  , 'like' , '%'. $search .'%')
                            ->where('price'             , 'like' , '%'. $search .'%')
                           ->orWhere('paid_at'          , 'like' , '%'. $search .'%')
                           ->orWhere('subscription_id'  , 'like' , '%'. $search .'%');
                });
    
        if ($request['req']['from'] != '')
            $query->whereDate('paid_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('paid_at'  , '<=' , $request['req']['to']);

        return $query;
    }

}
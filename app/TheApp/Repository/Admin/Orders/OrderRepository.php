<?php
namespace App\TheApp\Repository\Admin\Orders;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\OrderStatus;
use App\Models\Order;
use Auth;
use DB;

class OrderRepository
{
    protected $model;

    function __construct(Order $order,OrderStatus $status)
    {
        $this->model        = $order;
        $this->modelStatus  = $status;
    }

    public function monthlyProfite()
    {
        $data["profit_dates"] = $this->model
                                ->where('order_status_id',5)
                                ->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
                                ->groupBy('date')
                                ->pluck('date');

        $profits = $this->model
                    ->where('order_status_id',5)
                    ->select(\DB::raw("sum(total) as profit"))
                    ->groupBy(\DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                    ->get();

        $data["profits"] = json_encode(array_pluck($profits, 'profit'));

        return $data;
    }

    public function ordersType()
    {
        $orders = $this->model
                    ->select("order_status_id", \DB::raw("count(id) as count"))
                    ->groupBy('order_status_id')
                    ->get();


        foreach ($orders as $order) {

            if ($order->order_status_id == 1) {
                $order->type = "قيد الانتظار";
            }elseif ($order->order_status_id == 2){
                $order->type ="تم قبول الطلب";
            }elseif ($order->order_status_id == 3){
                $order->type ="تم رفض الطلب";
            }elseif ($order->order_status_id == 4){
                $order->type ="فشلت عملية الدفع";
            }elseif ($order->order_status_id == 5){
                $order->type ="تم الدفع بنجاح";
            }

        }

        $data["ordersCount"] = json_encode(array_pluck($orders, 'count'));
        $data["ordersType"]  = json_encode(array_pluck($orders, 'type'));

        return $data;
    }

    public function countNewOrders()
    {
        return $this->model->where('order_status_id', 1)->count();
    }

    public function countDone()
    {
        return $this->model->where('order_status_id',5)->count();
    }

    public function totalProfit()
    {
        return $this->model->where('order_status_id',5)->sum('total');
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    public function getAllStatus($order = 'id', $sort = 'desc')
    {
        return $this->modelStatus->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function update($request , $id)
    {
        DB::beginTransaction();

        $order = $this->findById($id);

        try {
            
            $order->update([
                'order_status_id'      => $request['order_status_id'],
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }


    public function delete($id)
    {
        $order = $this->findById($id);
        return $order->delete();
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
        $orders = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($orders))
        {
            foreach ($orders as $order)
            {
                $id = $order['id'];

                $show = btn('show','show_orders' , url(route('orders.show',$id)));

                $obj['id']               = $order->id;
                $obj['total']            = Price($order->total);
                $obj['subtotal']         = Price($order->subtotal);
                $obj['service']          = Price($order->service);
                $obj['method']           = Label($order->method,'label-info');
                $obj['order_status_id']  = OrderStatus($order);
                $obj['full_name']        = $order->user->name;
                $obj['email']            = $order->user->email;
                $obj['mobile']           = $order->user->mobile;
                $obj['created_at']       = date("d-m-Y", strtotime($order->created_at));
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
                    $query->where('id'          , 'like' , '%'. $search .'%')
                          ->orWhere('total'     , 'like' , '%'. $search .'%');
                });
        
        if ($request['user_id']) {
            $query->where('user_id',$request['user_id']);
        }

        if ($request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);


        return $query;
    }

}
<?php
namespace App\TheApp\Repository\Admin\Subscriptions;

use App\TheApp\Libraries\ImgRepository;
use App\Models\SubscriptionMonthly;
use App\Models\Subscription;
use Auth;
use DB;

class SubscriptionRepository
{
    protected $model;

    function __construct(Subscription $subscription,SubscriptionMonthly $monthly)
    {
        $this->model        = $subscription;
        $this->monthlyModel = $monthly;
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

    public function create($request)
    {
        DB::beginTransaction();
        
        try {
            
            $subscription = $this->model->create([
                'package_id'            => $request['package_id'],
                'user_id'               => $request['user_id'],
                'total'                 => $request['total'],
                'start_at'              => $request['start_at'],
                'end_at'                => $request['end_at'],
                'status'                => $request['status'],
                'next_billing'          => $request['next_billing'],
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
    
    public function update($request , $id)
    {
        try {
            
            $subscription = $this->findById($id);

            $subscription->update([
                'status'        => $request['status'],
                'next_billing'  => $request['next_billing'],
            ]);

            if (is_array_empty($request['price'])) {
                $this->createInvoice($request,$subscription);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }

    public function createInvoice($request,$subscription)
    {
        DB::beginTransaction();
        
        try {
        
            if ($subscription->monthlyBilling != null) {
                $this->monthlyModel->where('subscription_id',$subscription['id'])->delete();
            }

            foreach ($request['price'] as $key => $price) {

                $this->monthlyModel->create([
                    'price'              => $request['price'][$key],
                    'paid_at'            => $request['paid_at'][$key],
                    'subscription_id'    => $subscription['id'],
                ]);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
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
        $subscriptions = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($subscriptions))
        {
            foreach ($subscriptions as $subscription)
            {
                $id = $subscription['id'];

                $edit   = btn('edit'  ,'edit_subscriptions'  ,url(route('subscriptions.edit',$id)));
                $show   = btn('show','show_subscriptions' ,url(route('subscriptions.show',$id)));

                $obj['id']               = $subscription->id;
                $obj['start_at']         = $subscription->start_at;
                $obj['end_at']           = $subscription->end_at;
                $obj['next_billing']     = $subscription->next_billing;
                $obj['total']            = Price($subscription->total);
                $obj['status']           = Status($subscription->status);
                $obj['name']             = $subscription->user->name;
                $obj['email']            = $subscription->user->email;
                $obj['mobile']           = $subscription->user->mobile;
                $obj['created_at']       = date("d-m-Y", strtotime($subscription->created_at));
                $obj['listBox']          = checkBoxDelete($id);
                $obj['options']          = $edit . $show;;
                
                $data[] = $obj;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->model->where(function($query) use($search) {
                    $query->where('id'                 , 'like' , '%'. $search .'%')
                            ->where('total'            , 'like' , '%'. $search .'%')
                           ->orWhere('start_at'        , 'like' , '%'. $search .'%')
                           ->orWhere('end_at'          , 'like' , '%'. $search .'%');
                });
    
        if ($request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);
        
        if ($request['req']['active'] != '')
            $query->where('status' , $request['req']['active']);

        return $query;
    }

}
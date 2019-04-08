<?php
namespace App\TheApp\Repository\Admin\Subscriptions;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Auth;
use DB;

class SubscriptionRepository
{
    protected $model;

    function __construct(Subscription $subscription)
    {
        $this->model        = $subscription;
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
        $query = $this->model
                        ->where(function($query) use($search) {
                            $query
                            // SEARCH IN ORDERS TABLE
                            ->where('total'       , 'like' , '%'. $search .'%')
                            ->orWhere('id'        , 'like' , '%'. $search .'%');
                        });


        $output['recordsTotal']    = $query->count();
        $output['recordsFiltered'] = $query->count();
        $output['draw']            = intval($request->input('draw'));

        // Get Data
        $subscriptions = $query
                ->get();


        $data = array();
        if(!empty($subscriptions))
        {
            foreach ($subscriptions as $subscription)
            {
                $id = $subscription['id'];

                $show = btn('show','show_subscriptions'    ,url(route('subscriptions.show',$id)));

                $nestedData['id']               = $subscription->id;
                $nestedData['start_at']         = $subscription->start_at;
                $nestedData['end_at']           = $subscription->end_at;
                $nestedData['total']            = Price($subscription->total). ' دك';
                $nestedData['name']             = $subscription->user->name;
                $nestedData['email']            = $subscription->user->email;
                $nestedData['mobile']           = $subscription->user->mobile;
                $nestedData['created_at']       = transDate(date("d M-Y",strtotime($subscription->created_at)));
                
                $data[] = $nestedData;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

}
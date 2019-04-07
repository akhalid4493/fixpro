<?php
namespace App\TheApp\Repository\Admin\Users;

use Illuminate\Http\Request;
use App\Models\TechnicalShift;
use App\Models\TechnicalDay;
use App\Models\User;
use ImageTrait;
use Auth;
use DB;

class TechncialRepository
{
    protected $model;

    function __construct(User $user)
    {
        $this->model = $user;
    }
    
    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }
    
    public function TechnicalUsers()
    {
        return $this->model
                ->whereHas('roles.perms', function($query){
                            $query->where('name','technical_team');
                        })
                ->orderBy('id', 'desc')
                ->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function update($request , $id)
    {
        $user = $this->findById($id);

        $this->technicalShift($user,$request);
        $this->technicalWorkDays($user,$request);
        $user->servicesOfTechnical()->sync($request['services']);
        $user->locationsOfTechnical()->sync($request['governorates']);

        return true;
    }

    public function technicalShift($user,$request)
    {
        $from   = date('H:i:s', strtotime($request->from));
        $to     = date('H:i:s', strtotime($request->to));

        if ($user->shift == null) {

            $shift = new TechnicalShift([ 'from'=>$from , 'to' => $to ]);
            return $user->shift()->save($shift);
        
        }else{

            return $user->shift->update([ 'from'=>$from , 'to' => $to ]);

        }

        return true;
    }

    public function technicalWorkDays($user,$request)
    {
        TechnicalDay::where('user_id',$user['id'])->delete();
        if (is_array_empty($request['days'])) {
            foreach ($request['days'] as $day) {
                TechnicalDay::create([
                    'day'       =>$day,
                    'user_id'   =>$user['id'],
                ]);
            }
        }
            
        return true;
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
        $users = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($users))
        {
            foreach ($users as $user)
            {
                $id = $user['id'];

                $show   = btn('show'  ,'show_technicals'  ,url(route('technicals.show',$id)));
                $edit   = btn('edit'  ,'edit_technicals'  ,url(route('technicals.edit',$id)));

                $obj['id']          = $id;
                $obj['name']        = $user->name;
                $obj['mobile']      = $user->mobile;
                $obj['email']       = $user->email;
                $obj['image']       = url($user->image);
                $obj['roles']       = $user->roles;
                $obj['active']      = Status($user->active);
                $obj['created_at']  = date("d-m-Y", strtotime($user->created_at));
                $obj['listBox']     = checkBoxDelete($id);
                $obj['options']      = $edit;

                $data[] = $obj;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->model
                ->whereHas('roles.perms', function($query){
                    $query->where('name','technical_team');
                })
                ->where(function($query) use($search) {
                    $query
                    // SEARCH IN USER TABLE
                    ->where('id'            , 'like' , '%'. $search .'%')
                    ->orWhere('name'   , 'like' , '%'. $search .'%')
                    ->orWhere('mobile'      , 'like' , '%'. $search .'%')
                    ->orWhere('email'       , 'like' , '%'. $search .'%')

                    // SEARCH IN ROLES TABLE
                    ->orWhereHas('roles', function ($query) use ($search){
                        $query->where('display_name', 'like', '%'.$search.'%');
                    });
                });

    
        if ($request['req']['from'] != '')
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if ($request['req']['active'] != '')
            $query->where('active' , $request['req']['active']);

        if ($request['req']['roles'] != ''){

            if($request['req']['roles'] == 'normal') {
                $query->doesnthave('roles');
            }else{
                $query->whereHas('roles', function ($query) use ($request){
                    $query->where('id',$request['req']['roles']);
                });
            }

        }

        return $query;
    }
}
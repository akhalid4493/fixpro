<?php
namespace App\TheApp\Repository\Admin\Roles;

use App\Models\Role;
use DB;

class RoleRepository
{
    protected $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
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
            
            $role = $this->model->create([
                    'name'         => str_slug($request['name']),
                    'display_name' => $request['name'],
                    'description'  => $request['description'],
                ]);

            foreach ($request['permission'] as $key => $value) {
                $role->attachPermission($value);
            }

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
            
            $role = $this->findById($id);
            
            $role->update([
                'name'         => str_slug($request['name']),
                'display_name' => $request['name'],
                'description'  => $request['description'],
            ]);

            DB::table('permission_role')->where('role_id',$id)->delete();
            foreach ($request['permission'] as $key => $value) {
                $role->attachPermission($value);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }


    public function delete($id)
    {
        $role = $this->model->find($id);
        return $role->delete();
    }

    public function deleteAll($request)
    {
        return $roles = $this->model->destroy($request['ids']);
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
        $roles = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($roles))
        {
            foreach ($roles as $role)
            {
                $id = $role['id'];

                $edit   = btn('edit'  ,'edit_roles'  ,url(route('roles.edit',$id)));
                $delete = btn('delete','delete_roles',url(route('roles.show',$id)));

                $obj['id']           = $id;
                $obj['name']         = $role->display_name;
                $obj['display_name'] = $role->display_name;
                $obj['created_at']   = date("d-m-Y", strtotime($role->created_at));
                $obj['options']      = $edit . $delete;
                $obj['listBox']      = checkBoxDelete($id);
                
                $data[] = $obj;
            }
        }

        $output['data']  = $data;
        
        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->model
                ->where(function($query) use($search,$request) {
                    $query
                    ->where('id'                , 'like' , '%'. $search .'%')
                    ->orWhere('name'            , 'like' , '%'. $search .'%')
                    ->orWhere('display_name'    , 'like' , '%'. $search .'%')
                    ->orWhere('description'     , 'like' , '%'. $search .'%');
                });
    
        if ($request['req']['from'] != '')
            $query->where('created_at'  , '>=' , $request['req']['from']);

        if ($request['req']['to'] != '')
            $query->where('created_at'  , '<=' , $request['req']['to']);

        return $query;
    }

}
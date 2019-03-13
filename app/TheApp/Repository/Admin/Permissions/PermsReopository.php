<?php
namespace App\TheApp\Repository\Admin\Permissions;

use App\Models\Permission;

class PermsReopository
{
    protected $model;

    public function __construct(Permission $perms)
    {
        $this->model = $perms;
    }  

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($request)
    {
        try {
            
            $show = [
            'name'         => 'show_'.$request->input('name'),
            'display_name' => $request->input('name'),
            'description'  => 'show '.$request->input('name'). ' list',
            ];
            $add = [
                'name'         => 'add_'.$request->input('name'),
                'display_name' => $request->input('name'),
                'description'  => 'add '.$request->input('name'). ' permission',
            ];

            $edit = [
                'name'         => 'edit_'.$request->input('name'),
                'display_name' => $request->input('name'),
                'description'  => 'edit '.$request->input('name'). ' permission',
            ];

            $delete = [
                'name'         => 'delete_'.$request->input('name'),
                'display_name' => $request->input('name'),
                'description'  => 'delete '.$request->input('name'). ' permission',
            ];

            $this->model->insert([$show,$add,$edit,$delete]);

            return true;

        }catch(\Exception $e){
            return false;
        }
    }


    public function update($request , $id)
    {
        try {
            
            $role = $this->find($id);
            
            $role->update([
                'name'         => str_slug($request['name']),
                'display_name' => $request['name'],
                'description'  => $request['description'],
            ]);

            return true;

        }catch(\Exception $e){
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
        $permissions = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($permissions))
        {
            foreach ($permissions as $perm)
            {
                $id = $perm['id'];

                $obj['id']              = $id;
                $obj['description']     = $perm->description;
                $obj['name']            = $perm->name;
                $obj['display_name']    = $perm->display_name;
                $obj['created_at']      = date("d-m-Y", strtotime($perm->created_at));
                $obj['listBox']         = checkBoxDelete($id);
                
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
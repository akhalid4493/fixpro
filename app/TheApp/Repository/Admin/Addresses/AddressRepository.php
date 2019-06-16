<?php
namespace App\TheApp\Repository\Admin\Addresses;

use App\Models\Address;
use ImageTrait;
use Auth;
use DB;

class AddressRepository
{
    protected $model;

    function __construct(Address $address)
    {
        $this->model = $address;
    }

    public function count()
    {
        return $this->model->count();
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

            $address = $this->model->create([
                    'block'                 => $request['block'],
                    'street'                => $request['street'],
                    'house_no'              => $request['house_no'],
                    'building'              => $request['building'],
                    'province_id'           => $request['province_id'],
                    'floor'                 => $request['floor'],
                    'address'               => $request['address'],
                    'user_id'               => $request['user_id'],
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
        DB::beginTransaction();

        try {

            $address->update([
                'name_ar'               => $request['name_ar'],
                'name_en'               => $request['name_en'],
                'slug'                  => ar_slug($request['name_en']),
                'status'                => $request['status'],
                'image'                 => $img,
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
        DB::beginTransaction();

        try {

            $address = $this->findById($id);

            $address->delete();

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteAll($request)
    {
        DB::beginTransaction();

        try {

            $addresses = $this->model->whereIn('id',$request['ids'])->get();

            foreach ($addresses as $address) {
                $address->delete();
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
        $addresses = $query
                ->orderBy($sort['col'], $sort['dir'])
                ->skip($request->input('start'))
                ->take($request->input('length',10))
                ->get();


        $data = array();

        if(!empty($addresses))
        {
            foreach ($addresses as $address)
            {
                $id = $address['id'];

                // $edit   = btn('edit'  ,'edit_addresses'  ,url(route('addresses.edit',$id)));
                $delete = btn('delete','delete_addresses',url(route('addresses.show',$id)));

                $obj['id']          = $id;
                $obj['province_id'] = $address->addressProvince->name_ar;
                $obj['address']     = $address->address;
                $obj['block']       = $address->block;
                $obj['street']      = $address->street;
                $obj['building']    = $address->building;
                $obj['floor']       = $address->floor;
                $obj['house_no']    = $address->house_no;
                $obj['status']      = Status($address->status);
                $obj['created_at']  = date("d-m-Y", strtotime($address->created_at));
                $obj['listBox']     = checkBoxDelete($id);
                $obj['options']     = $delete;

                $data[] = $obj;
            }
        }

        $output['data']  = $data;

        return Response()->json($output);
    }

    public function filter($request,$search)
    {
        $query = $this->model
                ->where('user_id',$request['user_id'])
                ->where(function($query) use($search) {
                    $query
                    ->where('id' , 'like' , '%'. $search .'%');
                });

        return $query;
    }
}

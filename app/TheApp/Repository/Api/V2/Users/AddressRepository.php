<?php
namespace App\TheApp\Repository\Api\V2\Users;

use Illuminate\Http\Request;
use App\Models\Governorate;
use App\Models\Province;
use App\Models\Address;
use ImageTrait;
use Auth;
use DB;

class AddressRepository
{
    protected $model;

    function __construct(Address $address , Governorate $governorate , Province $province)
    {
        $this->model        = $address;
        $this->governorate  = $governorate;
        $this->province     = $province;
    }

    public function allGovernorates()
    {
        $governorates = $this->governorate
                        ->where('status',1)
                        ->orderBy('name_ar','DESC')
                        ->get();

        return $governorates;
    }

    public function allProvinces($request)
    {
        $provinces = $this->province->where('status',1)->orderBy('name_ar','DESC');

        if ($request['governorate_id'] != null) {
            $provinces->where('governorate_id',$request['governorate_id']);
        }

        $provinces = $provinces->get();

        return $provinces;
    }

    public function createAddress($request)
    {
        DB::beginTransaction();

        try {

            $address = $this->model->create([
                    'lat'           => $request['lat'],
                    'lang'          => $request['lang'],
                    'province_id'   => $request['province_id'],
                    'block'         => $request['block'],
                    'street'        => $request['street'],
                    'building'      => $request['building'],
                    'floor'         => $request['floor'],
                    'house_no'      => $request['house_no'],
                    'note'          => $request['note'],
                    'address'       => $request['address'],
                    'user_id'       => Auth::user()->id,
                ]);

            DB::commit();

            return $address;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function updateAddress($request,$id)
    {
        DB::beginTransaction();

        try {

            $address = $this->model
                            ->where('user_id',Auth::user()->id)
                            ->where('id',$id)
                            ->first();

            $address->update([
                    'lat'           => $request['lat'],
                    'lang'          => $request['lang'],
                    'province_id'   => $request['province_id'],
                    'block'         => $request['block'],
                    'street'        => $request['street'],
                    'building'      => $request['building'],
                    'floor'         => $request['floor'],
                    'house_no'      => $request['house_no'],
                    'note'          => $request['note'],
                    'address'       => $request['address'],
                    'user_id'       => Auth::user()->id,
            ]);

            DB::commit();

            return $address;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteAddress($id)
    {
        $address = $this->model
                        ->where('user_id',Auth::user()->id)
                        ->where('id',$id)
                        ->first();

        if ($address) {
            $delete = $address->delete();
            return true;
        }

        return false;
    }
}

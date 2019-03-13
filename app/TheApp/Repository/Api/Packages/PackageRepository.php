<?php
namespace App\TheApp\Repository\Api\Packages;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Package;
use Auth;
use DB;

class PackageRepository
{

    protected $model;

    function __construct(Package $package,Subscription $subscription)
    {
        $this->model        = $package;
        $this->subscription = $subscription;
    }  

    public function myPackages()
    {
        $packages = $this->model->where('user_id',Auth::user()->id)->get();

        return $packages;
    }

    public function packageById($id)
    {
        $package = $this->model->find($id);

        return $package;
    }

    public function myPackageById($id)
    {
        $package = $this->packageById($id)
                        ->where('id',$id)
                        ->where('user_id',Auth::user()->id)
                        ->first();
        return $package;
    }

    public function finalStep($data)
    {
        $package = $this->packageById($data['udf1']);

        DB::beginTransaction();

        try {
            
            $subscription = $this->subscription->create([
                'user_id'      => $package['user_id'],
                'package_id'   => $package['id'],
                'start_at'     => date('Y-m-d'),
                'end_at'       => date('Y-m-d', strtotime('+'.$package['months'].'months')),
                'price'        => $package['price'],
            ]);

            DB::commit();
            
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

}
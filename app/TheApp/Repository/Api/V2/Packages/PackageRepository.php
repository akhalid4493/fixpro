<?php
namespace App\TheApp\Repository\Api\V2\Packages;

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

    public function getAll()
    {
        $packages = $this->model->get();

        return $packages;
    }

    public function packageById($id)
    {
        $package = $this->model->find($id);

        return $package;
    }

}

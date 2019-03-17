<?php
namespace App\TheApp\Repository\Api\Installations;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Installation;
use Auth;
use DB;

class InstallationRepository
{
    protected $model;

    function __construct(Installation $installation)
    {
        $this->model  = $installation;
    }  

    public function getAll($request)
    {
        $installation = $this->model
               ->where('status',1)
               ->orderBy('id','desc');
        
        if ($request['type'])
            $product = $installation->where('type', $request['type']);


        $installations = $installation->get();

        return $installations;
    }

    public function findById($id)
    {
    	$installation = $this->model->find($id);

        return $installation;
    }
}
<?php
namespace App\TheApp\Repository\Api\V2\Installations;

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

        if ($request['category_id']){
            $installation->whereHas('categories', function($query) use($request){
                $query->where('category_id',$request['category_id']);
            });
        }


        $installations = $installation->get();

        return $installations;
    }

    public function findById($id)
    {
    	$installation = $this->model->find($id);

        return $installation;
    }
}

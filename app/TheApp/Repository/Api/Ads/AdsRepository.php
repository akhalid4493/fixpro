<?php
namespace App\TheApp\Repository\Api\Ads;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Ads;
use Auth;
use DB;

class AdsRepository
{
    protected $model;

    function __construct(Ads $ads)
    {
        $this->model  = $ads;
    }

    public function getAll()
    {
        return $ads = $this->model
               ->where('status',1)
               ->where('end_at','>=',date('Y-m-d'))
               ->where('start_at','<=',date('Y-m-d'))
               ->orderBy('id','desc')
               ->get();
    }
}

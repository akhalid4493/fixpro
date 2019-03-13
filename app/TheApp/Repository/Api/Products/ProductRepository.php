<?php
namespace App\TheApp\Repository\Api\Products;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use DB;

class ProductRepository
{
    protected $model;

    function __construct(Product $prdouct)
    {
        $this->model  = $prdouct;
    }  

    public function getAll($request)
    {
        $prdouct = $this->model
               ->where('status',1)
               ->orderBy('id','desc');
        
        if ($request['type'])
            $product = $prdouct->where('type', $request['type']);


        $prdoucts = $prdouct->get();

        return $prdoucts;
    }

    public function findById($id)
    {
    	$prdouct = $this->model->find($id);

        return $prdouct;
    }
}
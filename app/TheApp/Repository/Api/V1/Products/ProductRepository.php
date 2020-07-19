<?php
namespace App\TheApp\Repository\Api\V1\Products;

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
               ->where('qty','!=',0)
               ->orderBy('id','desc');

        if ($request['category_id']){
            $prdouct->whereHas('categories', function($query) use($request){
                $query->where('category_id',$request['category_id']);
            });
        }

        $prdoucts = $prdouct->get();

        return $prdoucts;
    }

    public function findById($id)
    {
    	$prdouct = $this->model->find($id);

        return $prdouct;
    }
}

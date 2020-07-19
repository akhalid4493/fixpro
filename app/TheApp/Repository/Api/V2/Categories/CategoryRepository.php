<?php
namespace App\TheApp\Repository\Api\V2\Categories;

use App\TheApp\Libraries\ImgRepository;
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use DB;

class CategoryRepository
{
    protected $model;

    function __construct(Category $category)
    {
        $this->model  = $category;
    }

    public function getAll($request)
    {
        return $categories = $this->model
                                 ->where('status',1)
                                 ->orderBy('id','desc')
                                 ->get();
    }

    public function findById($id)
    {
    	$installation = $this->model->find($id);

        return $installation;
    }


    public function getAllForTechnicalUser($request)
    {
        $idsOfCategories = Auth::user()->categoriesOfTechnical->pluck('pivot.category_id');

        $categories = $this->model
                           ->where('status',1)
                           ->orderBy('id','desc');

        if (count($idsOfCategories) > 0) {

          $categories->whereIn('id',$idsOfCategories);

        }

      return $categories->get();
    }

    public function findByIdForTecnicalUser($id)
    {
    	$installation = $this->model->find($id);

        return $installation;
    }
}

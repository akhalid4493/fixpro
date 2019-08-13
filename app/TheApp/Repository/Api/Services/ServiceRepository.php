<?php
namespace App\TheApp\Repository\Api\Services;

use Illuminate\Http\Request;
use App\Models\Service;
use Auth;
use DB;

class ServiceRepository
{
    protected $model;

    function __construct(Service $service)
    {
        $this->model         = $service;
    }

    public function getAll()
    {
        $service = $this->model
               ->where('status',1)
               ->orderBy('position','ASC')
               ->get();

        return $service;
    }

    public function getMyAds($request)
    {
        $ads = $this->model->where('user_id',$request['user_id'])->orderBy('id','desc')->get();

        return $ads;
    }

    public function findById($id)
    {
    	$ad = $this->model->find($id);

        return $ad;
    }

    public function create($request)
    {
        if ($request['head_image'] != '')
            $image = ImgRepository::uploadImage($request['head_image']);
        else
            $image  = 'uploads/default.png';

        DB::beginTransaction();

        try {

            $ad = $this->model->create([
                    'name'           => $request['name'],
                    'description'    => $request['description'],
                    'price'          => $request['price'],
                    'service_id'    => $request['service_id'],
                    'brand_id'       => $request['brand_id'],
                    'user_id'        => $request['user_id'],
                    'status'         => 1,
                    'image'          => $image
                ]);

            $payment = $this->paymentsModel->send($request,$ad);

            DB::commit();

            return ['adId' => $ad['id'] , 'paymentUrl' => $payment['paymentURL']];

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function renewAds($request)
    {
        $ad = $this->findById($request['ad_id']);

        if ($ad) {
            $payment = $this->paymentsModel->send($request,$ad);

            return $payment['paymentURL'];
        }

        return false;
    }

    public function createGallery($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['image'] as $img) {

            $image = ImgRepository::mulitUploads($img);

            $adImages = $this->imagesModel->create([
                    'image'     => $image,
                    'ad_id'     => $request['ad_id'],
                ]);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function changeStatus($request)
    {
        $ad = $this->findById($request['ad_id']);

        if ($ad) {
            return $ad->update([
                'enable'    => $request['status']
            ]);
        }

        return false;
    }

    public function deleteAd($id)
    {
        $ad = $this->findById($id);

        if ($ad) {
            return $ad->delete();
        }

        return false;
    }

    public function deleteGallary($id)
    {
        $img = $this->imagesModel->find($id);
        return $img->delete();
    }
}

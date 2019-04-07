<?php

namespace App\TheApp\Traits;

use App\Models\TechnicalPreview;
use App\Models\PreviewDate;
use App\Models\User;
use Carbon\Carbon;
use DB;

trait PreviewTrait
{
    static public function technicalOfService($preview)
    {
        $technicals = User::where('active',1)
                            ->whereHas('roles.perms', function($query){
                                $query
                                ->where('name','technical_team');
                            })
                            ->whereHas('workDays', function($query) use($preview) {
                                $query
                                ->where('day',self::dayOfPreview($preview));
                            })
                            ->whereHas('servicesOfTechnical', function($query) use($preview) {
                                $query
                                ->whereIn('service_id',self::getServicesIds($preview));
                            })
                            ->whereHas('locationsOfTechnical', function($query) use($preview) {
                                $query
                                ->where('province_id',self::getProvinceId($preview));
                            });

        $usersId = self::technicalShift($technicals->get(),$preview);

        return User::whereIn('id',$usersId)->get();
    }

    static public function getProvinceId($preview)
    {
        return $preview->address->addressProvince->id;
    }

    static public function getServicesIds($preview)
    {
        $id = array();

        foreach ($preview->details as $service) {
            $id[] = $service['service_id'];
        }

        return $id;
    }

    static public function dayOfPreview($preview)
    {
        return date('l', strtotime($preview->time));
    }

    static public function dateOfPreview($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    static public function hourOfPreview($preview)
    {
        return date('H:i:s', strtotime($preview->time));
    }

    static public function technicalShift($users,$date)
    {
        $data = array();

        foreach ($users as $user) {
            $data[] = $user->shift;
        }


        $userId = array();

        foreach ($data as $shift) {

            $data =self::shifts($shift,$date);

            if ($data['startShift'] < $date && $date < $data['endShift']) {

                $userId[] = $shift['user_id'];

            }

            
        }

        return $userId;
    }

    static public function shifts($shift,$date)
    {
        $data = array();

        if ($shift->from > $shift->to){

            $startShift = date(self::dateOfPreview($date).' '.$shift->from);
            $dateOfEnd  = date(self::dateOfPreview($date).' '.$shift->to);
            $endShift   = date('Y-m-d H:i:s',strtotime($dateOfEnd . ' +1 day'));

            $data['startShift'] = $startShift;
            $data['endShift']   = $endShift;

        }elseif($shift->from < $shift->to){

            $startShift = date(self::dateOfPreview($date).' '.$shift->from);
            $endShift   = date(self::dateOfPreview($date).' '.$shift->to);

            $data['startShift'] = $startShift;
            $data['endShift']   = $endShift;
        }

        return $data;
    }

    // static public function checkAvilable()
    // {
    //     $techPreview = PreviewDate::where('date','>=',Carbon::now())
    //                           ->whereHas('preview', function($query) {
    //                                 $query
    //                                 ->where('preview_status_id','!=',6)
    //                                 ->where('preview_status_id','!=',5);
    //                             })
    //                           ->select('date', DB::raw('count(*) as dates'),'service_id','province_id')
    //                           ->groupBy('date','service_id','province_id')
    //                           ->get();

    //     $offDays = array();

    //     foreach ($techPreview as $key => $date) {

    //        $users = User::
    //                 whereHas('servicesOfTechnical', function($query) use($date) {
    //                     $query->where('service_id',$date->service_id);
    //                 })
    //                 ->whereHas('locationsOfTechnical', function($query) use($date) {
    //                     $query->where('province_id',$date->province_id);
    //                 })
    //                 ->get();

    //         if ($techPreview[$key]['dates'] >= count($users)) {

    //             $obj['date']        = $users;
    //             $obj['service_id']  = $date['service_id'];
    //             $obj['province_id'] = $date['province_id'];
    //             $obj['off']         = true;

    //         }

    //     $offDays = $obj;                

    //     }

    //     return $offDays;
    // }

    static public function checkAvilable($date,$service_id,$province_id)
    {
        $day = date('l', strtotime($date));

        $users = User::where('active',1)
                            ->whereHas('workDays', function($query) use($day) {
                                $query->where('day',$day);
                            })
                            ->whereHas('servicesOfTechnical', function($query) use($service_id) {
                                $query->where('service_id',$service_id);
                            })
                            ->whereHas('locationsOfTechnical', function($query) use($province_id) {
                                $query->where('province_id',$province_id);
                            })
                            ->whereHas('roles.perms', function($query){
                                $query
                                ->where('name','technical_team');
                            });

        $usersId = self::technicalShift($users->get(),$date);

        $availableTechnicals = User::whereIn('id',$usersId)->count();

        $previews = PreviewDate::where('date','>=',Carbon::now())
                                ->where('service_id',$service_id)
                                ->where('province_id',$province_id)
                                ->whereHas('preview', function($query) {
                                    $query
                                    ->where('preview_status_id','!=',6)
                                    ->where('preview_status_id','!=',5);
                                })
                                ->select('date', DB::raw('count(*) as dates'))
                                ->groupBy('date')
                                ->count();

        if ($availableTechnicals <= $previews) {
            return ['date' => $date,'off' => true];
        }
    }
}
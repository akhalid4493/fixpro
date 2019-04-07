<?php

namespace App\TheApp\CustomClass;

use App\Models\TechnicalPreview;
use App\Models\PreviewDate;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use DB;

class PreviewCheck
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
                                ->where('day',self::dayOfPreview($preview->time));
                            })
                            ->whereHas('servicesOfTechnical', function($query) use($preview) {
                                $query
                                ->whereIn('service_id',self::getServicesIds($preview));
                            })
                            ->whereHas('locationsOfTechnical', function($query) use($preview) {
                                $query
                                ->where('governorate_id',self::getGovernorateId($preview));
                            })->get();

        $usersId = self::technicalShift($technicals,$preview);

        return User::whereIn('id',$usersId)->get();
    }

    static public function getGovernorateId($preview)
    {
        return $preview->address->addressProvince->governorate_id;
    }

    static public function getServicesIds($preview)
    {
        $id = array();

        foreach ($preview->details as $service) {
            $id[] = $service['service_id'];
        }

        return $id;
    }

    static public function dayOfPreview($date)
    {
        return date('l', strtotime($date));
    }

    static public function dateOfPreview($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    static public function hourOfPreview($date)
    {
        return date('H:i:s', strtotime($date));
    }

    static public function technicalShift($users,$preview)
    {
        $data = array();

        foreach ($users as $user) {
            $data[] = $user->shift;
        }

        $userId = array();

        foreach ($data as $shift) {

            $workShift = self::shifts($shift,$preview);

            if ($workShift['startShift'] < $preview->time && $preview->time < $workShift['endShift']) {

                $userId[] = $shift['user_id'];

            }
        }

        return $userId;
    }

    static public function shifts($shift,$preview)
    {
        $data = array();

        if ($shift->from > $shift->to){

            $startShift = date(self::dateOfPreview($preview->time).' '.$shift->from);
            $dateOfEnd  = date(self::dateOfPreview($preview->time).' '.$shift->to);
            $endShift   = date('Y-m-d H:i:s',strtotime($dateOfEnd . ' +1 day'));

            $data['startShift'] = $startShift;
            $data['endShift']   = $endShift;

        }elseif($shift->from < $shift->to){

            $startShift = date(self::dateOfPreview($preview->time).' '.$shift->from);
            $endShift   = date(self::dateOfPreview($preview->time).' '.$shift->to);

            $data['startShift'] = $startShift;
            $data['endShift']   = $endShift;
        }

        return $data;

    }

    static public function previewInSameDate($techincal,$preview)
    {
        if ($techincal->previewsOfTechnical) {
            foreach ($techincal->previewsOfTechnical as $previewsOfTechnical) {
                
                if ($previewsOfTechnical->time==$preview->time&&$previewsOfTechnical->id!=$preview->id){
                    return true;
                }
            }
        }
    }

    /* 
    ====================================
    *         Not Available Dates
    =====================================
    */ 
   
    static public function getPreviews($serviceId,$locationId)
    {
        $previewDates = self::groupDates($serviceId,$locationId);
        $techincals   = self::getTechnicals($previewDates);

        return $techincals;
    }

    static public function groupDates($serviceId,$locationId)
    {
        $dates = PreviewDate::where('date','>=',Carbon::now())
                ->where('governorate_id',$locationId)
                ->where('service_id',$serviceId)
                ->whereHas('preview', function($query) {
                    $query
                    ->where('preview_status_id','!=',6)
                    ->where('preview_status_id','!=',5);
                })
                ->select('date as time', DB::raw('count(*) as dates'),'service_id','governorate_id')
                ->groupBy('date','service_id','governorate_id')
                ->get();

        return $dates;
    }

    static public function getTechnicals($previewDates)
    {
        $offDays = array();

        foreach ($previewDates as $key => $date) {

           $users = User::where('active',1)
                    ->whereHas('roles.perms', function($query){
                        $query
                        ->where('name','technical_team');
                    })
                    ->whereHas('workDays', function($query) use($date) {
                        $query
                        ->where('day',self::dayOfPreview($date));
                    })
                    ->whereHas('servicesOfTechnical', function($query) use($date) {
                        $query->where('service_id',$date->service_id);
                    })
                    ->whereHas('locationsOfTechnical', function($query) use($date) {
                        $query
                        ->where('governorate_id',$date->governorate_id);
                    })->get();

            $usersId = self::technicalShift($users,$date);
            $usersCounter = User::whereIn('id',$usersId)->get();


            if ($previewDates[$key]['dates'] >= count($usersCounter)) {

                $obj['dateTime']        = $date['time'];
                $obj['time']            = self::hourOfPreview($date['time']);
                $obj['date']            = self::dateOfPreview($date['time']);
                $obj['service_id']      = $date['service_id'];
                $obj['governorate_id']  = $date['governorate_id'];
                $obj['off']             = true;
    
                $offDays[] = $obj;
            }
        }

        return $offDays;
    }
}
<?php

namespace App\TheApp\Traits;

use App\Models\TechnicalPreview;
use App\Models\Preview;
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

    static public function dateOfPreview($preview)
    {
        return date('Y-m-d', strtotime($preview->time));
    }

    static public function hourOfPreview($preview)
    {
        return date('H:i:s', strtotime($preview->time));
    }

    static public function technicalShift($users,$preview)
    {
        $data = array();

        foreach ($users as $user) {
            $data[] = $user->shift;
        }


        $userId = array();

        foreach ($data as $shift) {

            
            if ($shift->from > $shift->to){

                $startShift = date(self::dateOfPreview($preview).' '.$shift->from);
                $dateOfEnd  = date(self::dateOfPreview($preview).' '.$shift->to);
                $endShift   = date('Y-m-d H:i:s',strtotime($dateOfEnd . ' +1 day'));

                if ($startShift < $preview->time && $preview->time < $endShift) {

                    $userId[] = $shift['user_id'];

                }

            }elseif($shift->from < $shift->to){

                $startShift = date(self::dateOfPreview($preview).' '.$shift->from);
                $endShift   = date(self::dateOfPreview($preview).' '.$shift->to);

                if ($startShift < $preview->time && $preview->time < $endShift) {

                    $userId[] = $shift['user_id'];

                }

            }

            
        }

        return $userId;
    }

    static public function checkAvilable()
    {
        $techPreview = TechnicalPreview::where('date','>=',Carbon::now())
                              ->select('date', DB::raw('count(*) as dates'),'service_id','province_id')
                              ->groupBy('date','service_id','province_id')
                              ->get();

        $offDays = array();

        foreach ($techPreview as $key => $counter) {

           $users = User::
                    whereHas('servicesOfTechnical', function($query) use($counter) {
                        $query->where('service_id',$counter->service_id);
                    })
                    ->whereHas('locationsOfTechnical', function($query) use($counter) {
                        $query->where('province_id',$counter->province_id);
                    })
                    ->count();

            if ($techPreview[$key]['dates'] >= $users) {

                $obj['date']        = $counter['date'];
                $obj['service_id']  = $counter['service_id'];
                $obj['province_id'] = $counter['province_id'];
                $obj['off']         = true;
                
                $offDays = $obj;
            }

        }

        return $offDays;
    }
}
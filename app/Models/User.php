<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use EntrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email',
        'mobile',
        'image',
        'active',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function orders()
    {       
        return $this->hasMany('App\Models\Order');
    }

    public function hasSubscription()
    {       
        return $this->hasOne('App\Models\Subscription');
    }

    public function checkSubscription()
    {       
        return $this->hasSubscription()->where('end_at','>',date('Y-m-d'));
    }

    public function address()
    {
        return $this->hasMany('App\Models\Address');
    }
    
    public function workDays()
    {
        return $this->hasMany('App\Models\TechnicalDay');
    }

    public function previewsOfTechnical()
    {
        return $this->belongsToMany('App\Models\Preview', 'technical_previews');
    }

    public function deviceToken()
    {       
        return $this->hasOne('App\Models\DeviceToken')->latest();
    }

    public function shift()
    {       
        return $this->hasOne('App\Models\TechnicalShift')->latest();
    }

    public function subscription()
    {
        return $this->hasOne('App\Models\UserSubscription')->latest();
    }

    public function servicesOfTechnical()
    {
        return $this->belongsToMany('App\Models\Service', 'technical_services');
    }

    public function locationsOfTechnical()
    {
        return $this->belongsToMany('App\Models\Governorate', 'technical_locations');
    }
}

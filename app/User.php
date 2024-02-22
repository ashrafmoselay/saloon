<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Notifiable,HasRoles,HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','treasury_id','show_cost_price','show_sale_price'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function stores(){
        return $this->belongsToMany(Store::class,'user_stores','user_id','store_id')
            ->withTimestamps();
    }
    public function getStoresIdsAttribute(){
        return $this->stores()->pluck('store_id')->toArray();
    }

    public function treasury(){
        return $this->belongsTo(Bank::class,'treasury_id','id');
    }

}

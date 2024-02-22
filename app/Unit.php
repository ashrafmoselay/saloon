<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    protected $table = 'units';
    protected $fillable = ['name'];

    protected $appends = array('cost_price','sale_price','gomla_price','gomla_gomla_price');

    public function getCostPriceAttribute()
    {
        $price =  $this->pivot->cost_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }
    public function getSalePriceAttribute()
    {
        $price =  $this->pivot->sale_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }
    public function getGomlaPriceAttribute()
    {
        $price =  $this->pivot->gomla_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }
    public function getGomlaGomlaPriceAttribute()
    {
        $price =  $this->pivot->gomla_gomla_price??0;
        return currency($price,currency()->config('default'), currency()->getUserCurrency(), $format = false);
    }
    public function products(){
        return $this->hasMany(ProductUnit::class);
    }

}

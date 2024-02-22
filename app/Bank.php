<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';

    protected $fillable = ['name','number','balance','percent','currency','type'];

    public function getCreatedAtAttribute($value)
    { 
        return date('Y-m-d', strtotime($value));
    }
    public function transactions(){
        return $this->hasMany(BankTransaction::class);
    }
/*
    public function getBalanceAttribute($value)
    {
        $value =  currency($value,$this->currency,currency()->getUserCurrency(), $format = true);
        return round($value,2);
    }*/

}

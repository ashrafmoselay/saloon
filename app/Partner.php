<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{

    use SoftDeletes;
    protected $table = 'partners';
    protected $fillable = ['name','value'];

    public function expenses(){
        $from= request('fromdate');
        $to= request('todate');
        $expenses = $this->hasMany(Expense::class,'partner_id','id');
        if($from){
            $expenses->whereRaw("DATE(created_at) >= '{$from}'");
        }
        if($to){
            $expenses->whereRaw("DATE(created_at) <= '{$to}'");
        }
        return $expenses;
    }

    public function partnerprofit(){
        $from= request('fromdate');
        $to= request('todate');
        $partnerprofit = $this->hasMany(PartnerProfit::class,'partner_id','id');
        if($from){
            $partnerprofit->whereRaw("DATE(created_at) >= '{$from}'");
        }
        if($to){
            $partnerprofit->whereRaw("DATE(created_at) <= '{$to}'");
        }
        return $partnerprofit;
    }

    public function stores(){
        return $this->belongsToMany(Store::class,'partner_stores','partner_id','store_id')
            ->withPivot('percent');
    }

    public function firststore(){
        return $this->hasOne(PartnerStore::class);
    }
}

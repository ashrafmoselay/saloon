<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    protected $fillable = ['store_id', 'product_id','qty','unit_id','note','damageoption_id','creator_id'];

    public function store(){
        return $this->belongsTo(Store::class,'store_id','id')->withTrashed();
    }

    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function unit(){
        return $this->belongsTo(Unit::class)->withTrashed();
    }
    public function damageoption(){
        return $this->belongsTo(DamageOption::class,'damageoption_id','id');
    }
    public function creator(){
        return $this->belongsTo(User::class,'creator_id','id');
    }
    public function scopeFilter($query)
    {
        $from = request('fromdate');
        $to = request('todate');
        if($from) {
            $query->whereDate('created_at','>=',$from);
        }
        if($to) {
            $query->whereDate('created_at','<=',$to);
        }
        return $query->latest();
    }
}

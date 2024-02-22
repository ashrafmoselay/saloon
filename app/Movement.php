<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $table = 'movements';
    protected $fillable = ['store_from_id','store_to_id','product_id','qty','unit_id','invoice_id'];

    public function to(){
        return $this->belongsTo(Store::class,'store_to_id','id')->withTrashed();
    }
    public function from(){
        return $this->belongsTo(Store::class,'store_from_id','id')->withTrashed();
    }
    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }
    public function unit(){
        return $this->belongsTo(Unit::class)->withTrashed();
    }
}

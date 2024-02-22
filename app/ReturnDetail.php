<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnDetail extends Model
{
    protected $table = 'return_detailes';

    protected $fillable = [
        'return_id','store_name','unit_name','product_name',
        'store_id','unit_id', 'qty','cost','price',
        'cost_egp','price_egp','product_id'
    ];
    public function returns(){
        return $this->belongsTo(ReturnProduct::class,'return_id','id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id','id')->withTrashed();
    }
}

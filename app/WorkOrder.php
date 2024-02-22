<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'workorders';
    protected $fillable = ['product_id','store_id','unit_id','unit_name','product_name','date','itemqty'];

    public function details(){
        return $this->belongsToMany(Product::class,'workorders_detailes','workorder_id','raw_unit_id')
            ->withPivot(['raw_name','totalneedqty','raw_unit_text']);
    }
}

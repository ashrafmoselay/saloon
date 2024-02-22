<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class ProductStore extends Model
{
    protected $table = 'product_store';

    protected $fillable = [
        'product_id','store_id','unit_id','qty','sale_count','cost'
    ];
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }


    public function getCost(){
        //dd( $this->unit_id,$this->product_id);

        $unitPrice =  $this->product
            ->productUnit()
            ->where('unit_id', $this->unit_id)
            ->where('product_id', $this->product_id)
            ->first();
        return ($unitPrice)?round($unitPrice->pivot->cost_price,2):0;
    }
}

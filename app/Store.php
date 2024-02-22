<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Store extends Model
{
    use SoftDeletes;
    protected $table = 'stores';
    protected $fillable = ['name','mobile','note'];

    public function products(){
        return $this->hasMany(ProductStore::class,'store_id','id');
    }

    // public function getGardAttribute(){
    //     $this->products()
    //         ->join('product_unit',function($join){
    //             $join->on('product_unit.unit_id','=','product_store.unit_id');
    //             $join->where(DB::raw('product_store.product_id=product_unit.product_id and store_id ='.$this->id));
    //         });

    //     sum((select sum(qty-sale_count) from product_store
    //     where product_unit.unit_id=product_store.unit_id and
    //     product_store.product_id=product_unit.product_id and store_id = '.$store->id.')
    //     * product_unit.cost_price) as totalCost
    // }

}

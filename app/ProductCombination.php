<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ProductCombination extends Model
{
    protected $table = 'product_combinations';
    protected $fillable = ['product_id','store_id','combination_id','qty','sale_counter'];

}

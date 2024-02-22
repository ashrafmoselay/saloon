<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductUnit extends Pivot
{
    use LogsActivity;
    protected $table = 'product_unit';
    protected static $logOnlyDirty = false;
    protected static $submitEmptyLogs = false;
    protected static $logFillable = true;
    protected $fillable = [
        'unit_id','product_id','pieces_num','cost_price','sale_price',
        'gomla_price','gomla_gomla_price','customer_price','half_gomla_price'
    ];
    protected static $logAttributes = [
        'unit_id','product_id','pieces_num','cost_price','sale_price','gomla_price','gomla_gomla_price'
    ];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}

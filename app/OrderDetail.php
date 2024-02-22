<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detailes';

    protected $fillable = [
        'order_id',
        'product_id',
        'store_id',
        'unit_id',
        'cost_egp',
        'price_egp',
        'bounse',
        'store_name',
        'unit_name',
        'product_name',
        'store_id',
        'unit_id',
        'qty',
        'bounse',
        'bounse_unit_id',
        'bounseUnitText',
        'is_service',
        'return_qty',
        'cost',
        'price',
        'total',
        'created_at',
        'markter',
        'bounse_unit_id',
        'bounseUnitText',
        'customer_price',
        'status',
        'comment',
        'discount1',
        'discount2',
        'serive_datetime', 'employee_id', 'employee_name'

    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function getCostAttribute($value)
    {
        return round($value, 2);
    }
    public function getPriceAttribute($value)
    {
        return round($value, 2);
    }
    public function getTotalAttribute($value)
    {
        return round($value, 2);
    }
}

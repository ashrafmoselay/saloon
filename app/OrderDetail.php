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

    public function scopeFilter($query)
    {
        $client_id = request('client_id');
        $fromdate = request('fromdate');
        $todate = request('todate');
        $employee_id = request('employee_id');
        $product_id = request('product_id');
        $status = request('status');
        if ($client_id) {
            $query->whereHas('order', function ($q) use ($client_id) {
                $q->where('client_id', $client_id);
            });
        }
        if ($product_id) {
            $query->where('product_id', $product_id);
        }
        if ($employee_id) {
            $query->where('employee_id', $employee_id);
        }
        if ($fromdate) {
            $query->whereDate('serive_datetime','>=', $fromdate);
        }
        if ($todate) {
            $query->whereDate('serive_datetime','<=', $todate);
        }
        if ($status) {
            $query->where('status', $status);
        }
        $keyword = request('keyword');
        if ($keyword) {
            $query->whereHas('order.client', function ($subqry) use ($keyword) {
                $subqry->where('name', 'like', '%' . $keyword . '%')
                    ->orwhere('mobile', 'like', '%' . $keyword . '%');;
            });;
        }
        return $query;
    }
}

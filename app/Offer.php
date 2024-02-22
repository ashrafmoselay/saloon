<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Offer extends Model
{
    use SoftDeletes;
    protected $table = 'offers';
    protected $fillable = [
        'invoice_number',
        'client_id',
        'total',
        'paid',
        'due',
        'tax',
        'discount',
        'discount_type',
        'is_paid',
        'note',
        'status',
        'created_at',
        'bank_id',
        'status',
        'meta',
        'invoice_date',
        'currency',
        'note',
        'priceType',
        'discount_value',
        'creator_id',
        'tax_value'
    ];
    protected $casts = [
        'totalDept' => 'double',
        'totalReturn' => 'double'
    ];
    public function transaction()
    {
        return $this->morphOne(BankTransaction::class, 'transactionable');
    }

    public function details()
    {
        return $this->belongsToMany(Product::class, 'offer_detailes', 'order_id', 'product_id')
            ->withPivot([
                'store_name',
                'unit_name',
                'product_name',
                'store_id',
                'unit_id',
                'qty',
                'cost',
                'price',
                'total',
                'created_at',
            ])
            ->withTimestamps();

    }
    public function client()
    {
        return $this->belongsTo(Person::class, 'client_id', 'id')->withTrashed();
    }


    public function getTotalAttribute($value)
    {
        $value = $value ? currency($value, $this->currency, $this->currency, $format = false) : 0;
        return round($value, 2);
    }

    public function getTotalCostAttribute()
    {
        return $this->hasMany(OfferDetail::class, 'order_id', 'id')
            ->sum(DB::raw('qty * cost'));
    }

    public function getOrderProfitAttribute()
    {
        $totalProfit = $this->hasMany(OfferDetail::class, 'order_id', 'id')
            ->sum(DB::raw('qty * (price - cost)'));
        $totalProfit = floatval($totalProfit);
        $discount = floatval($this->discount) ?: 0;
        if ($discount) {
            if ($this->discount_type == 2) {
                $discount = $this->total * ($this->discount / 100);
            }
        }
        return $totalProfit - $discount;
    }

    public function getFgrandOrderTotalAttribute()
    {
        return $this->hasMany(OfferDetail::class, 'order_id', 'id')->sum(DB::raw('(qty * price)'));
    }
    public function setDiscountValueAttribute($value)
    {
        $order = request()->all()['order'];
        $discount = $this->attributes['discount'] ?: 0;
        if ($discount && isset($this->attributes['discount_type'])) {
            if ($this->attributes['discount_type'] == 2) {
                $discount = $order['total'] * ($discount / 100);
            }
        }
        $this->attributes['discount_value'] = $discount;
    }
    public function getDicountValueAttribute()
    {

        $discount = $this->discount ?: 0;
        if ($discount) {
            if ($this->discount_type == 2) {
                $discount = $this->total * ($this->discount / 100);
            }
        }
        return $discount;
    }


    public function getTotalProfit()
    {
        return 0;
    }

    public function getDueAttribute($value)
    {
        $value = $value ? currency($value, $this->currency, $this->currency, $format = false) : 0;
        return round($value, 2);
    }
    public function getPaidAttribute($value)
    {
        $value = $value ? currency($value, $this->currency, $this->currency, $format = false) : 0;
        return round($value, 2);
    }




    public function scopePriceTypeOne($query)
    {
        return $query->where('priceType', 'one');
    }
    public function scopePriceTypeGomla($query)
    {
        return $query->where('priceType', 'multi');
    }
    public function scopePriceTypeGomlaGomla($query)
    {
        return $query->where('priceType', 'gomla_gomla_price');
    }
    public function scopeCashOrders($query)
    {
        return $query->where('payment_type', 'cash');
    }
    public function scopePostPaidOrders($query)
    {
        return $query->where('payment_type', 'delayed');
    }
    public function scopeVisaOrders($query)
    {
        return $query->where('payment_type', 'visa');
    }
    public function scopeLinkTransferOrders($query)
    {
        return $query->where('payment_type', 'link transfer');
    }
    /* public function getCreatedAtAttribute($value){
         return $value?date('Y-m-d', strtotime($value)):date('Y-m-d');
     }*/


    public function gettaxValueAttribute()
    {
        $tax = $this->tax / 100;
        $total = $this->total;
        $taxplusone = 1 + $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue = $orignalValue * $tax;
        return $taxvalue;
    }
    public function gettaxValueCaluclatedAttribute()
    {
        $tax = $this->tax / 100;
        $total = $this->total;
        $taxplusone = 1 + $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue = $orignalValue * $tax;
        return $taxvalue;
    }
    public function getTotalWithoutTaxAttribute()
    {
        $tax = $this->tax / 100;
        $total = $this->total;
        $taxplusone = 1 + $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue = $orignalValue * $tax;
        $value = $total - $taxvalue;
        return $value;
    }
}
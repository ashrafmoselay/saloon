<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'invoice_number',
        'client_id',
        'sale_id',
        'total',
        'paid',
        'due',
        'tax',
        'discount',
        'discount_type',
        'payment_type',
        'is_paid',
        'note',
        'status',
        'created_at',
        'bank_id',
        'status',
        'meta',
        'invoice_type',
        'invoice_date',
        'markter_id',
        'currency',
        'commision',
        'is_visa',
        'commision_egp',
        'is_withdrawable',
        'note',
        'manager_id',
        'profit',
        'priceType',
        'total_return',
        'auth_code',
        'use_point',
        'discount_value',
        'creator_id',
        'supplier_invoice_number',
        'tax_value',
        'is_shipped',
        'shipment_amount'
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
        return $this->belongsToMany(Product::class, 'order_detailes', 'order_id', 'product_id')
            ->withPivot([
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
                'customer_price',
                'status',
                'comment',
                'discount1',
                'discount2',
                'serive_datetime', 'employee_id', 'employee_name'
            ])
            ->withTimestamps();
    }
    public function client()
    {
        return $this->belongsTo(Person::class, 'client_id', 'id')->withTrashed();
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
    public function saleMan()
    {
        return $this->belongsTo(Employee::class, 'sale_id', 'id')->withTrashed();
    }
    public function market()
    {
        return $this->belongsTo(Employee::class, 'markter_id', 'id');
    }

    /*public function setTotalAttribute($value)
    {
        $this->attributes['total'] = currency($value,currency()->getUserCurrency(),currency()->config('default'), $format = false);
    }
    public function setPaidAttribute($value)
    {
        $this->attributes['paid'] = currency($value,currency()->getUserCurrency(),currency()->config('default'), $format = false);
    }
    public function setDueAttribute($value)
    {
        $this->attributes['due'] = currency($value,currency()->getUserCurrency(),currency()->config('default'), $format = false);
    }*/
    public function getTotalAttribute($value)
    {
        $value = $value ? currency($value, $this->currency, $this->currency, $format = false) : 0;
        return round($value, 2);
    }

    public function getTotalCostAttribute()
    {
        return $this->hasMany(OrderDetail::class)
            ->sum(DB::raw('(qty - return_qty) * cost'));
    }
    public function getTotalSaleAttribute()
    {
        return $this->hasMany(OrderDetail::class)
            ->sum(DB::raw('(qty - return_qty) * price'));
    }

    public function getOrderProfitAttribute()
    {
        $totalProfit = $this->hasMany(OrderDetail::class)
            ->sum(DB::raw('(qty - return_qty) * (price - cost)'));
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
        return $this->hasMany(OrderDetail::class)->sum(DB::raw('(qty * price) - (return_qty * price)'));
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

    public function calander()
    {
        return $this->hasMany(CalanderPayment::class);
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
    public function getOrderDateAttribute()
    {
        return $this->invoice_date . ' ' . $this->created_at->format('h:i');
    }


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
    public function generatQrcode($name, $taxNumber, $date, $TotalAmount, $TaxAmount)
    {
        try {
            if (!$TaxAmount) {
                return '';
            }
            $generatedString = GenerateQrCode::fromArray([
                new Seller($name),
                new TaxNumber($taxNumber),
                new InvoiceDate($date),
                new InvoiceTotalAmount($TotalAmount),
                new InvoiceTaxAmount($TaxAmount)
            ])->render();
            return $generatedString;
        } catch (\Exception $e) {
            return 0;
        }
    }
}

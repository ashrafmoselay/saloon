<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class ReturnProduct extends Model
{
    use SoftDeletes;
    protected $table = 'returns';
    protected $fillable = [
        'client_id','return_type','return_value','is_cash','return_date','currency','sales_value','sales_value_egp',
        'sale_id','discount','discount_type','total','manager_id','order_id','creator_id','tax','tax_value'
    ];

    public function gettaxValueAttribute(){
        $tax =  $this->tax/100;
        $total = $this->total;
        $taxplusone = 1+ $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue =$orignalValue * $tax;
        return $taxvalue;
    }
    public function gettaxValueCaluclatedAttribute(){
        $tax =  $this->tax/100;
        $total = $this->total;
        $taxplusone = 1+ $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue =$orignalValue * $tax;
        return $taxvalue;
    }
    public function transaction(){
        return $this->morphOne(BankTransaction::class,'transactionable');
    }
    public function details(){
        return $this->belongsToMany(Product::class,'return_detailes','return_id','product_id')
            ->withPivot(['store_name','unit_name','product_name','store_id','unit_id', 'qty','cost','price','created_at'])
            ->withTimestamps()->withTrashed();

    }
    public function creator(){
        return $this->belongsTo(User::class,'creator_id','id');
    }
    public function client(){
        return $this->belongsTo(Person::class,'client_id','id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id','id')->withTrashed();
    }
    public function saleMan(){
        return $this->belongsTo(Employee::class,'sale_id','id');
    }
}

<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Expense extends Model
{
    //use LogsActivity;
    protected $table = 'expenses';
    protected $fillable = [
        'note','value','bank_id','partner_id','expenses_type_id',
    'employee_id','created_at','creator_id','tax','tax_value'];

    //protected static $logAttributes = ['note','value','partner_id','expenses_type_id','employee_id','created_at'];
    public function partner(){
        return $this->belongsTo(Partner::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function gettaxValueAttribute(){
        $tax =  $this->tax/100;
        $total = $this->value;
        $taxplusone = 1+ $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue =$orignalValue * $tax;
        return round($taxvalue,2);
    }
    public function gettaxValueCaluclatedAttribute(){
        $tax =  $this->tax/100;
        $total = $this->value;
        $taxplusone = 1+ $tax;
        $orignalValue = $total / $taxplusone;
        $taxvalue =$orignalValue * $tax;
        return round($taxvalue,2);
    }

    public function getvalueBeforeTaxAttribute(){
        return $this->value - $this->tax_value;
    }
    public function type(){
        return $this->belongsTo(ExpensesType::class,'expenses_type_id','id');
    }
    public function transaction(){
        return $this->morphOne(BankTransaction::class,'transactionable');
    }

    public function creator(){
        return $this->belongsTo(User::class,'creator_id','id');
    }
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->creator_id = auth()->user()->id;
        });
    }
}

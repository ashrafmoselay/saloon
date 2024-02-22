<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalanderPayment extends Model
{
    protected $table = 'calander_payments';

    protected $fillable = [
        'order_id',
        'date',
        'value',
        'is_paid',
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }

}

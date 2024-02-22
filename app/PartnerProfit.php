<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class PartnerProfit extends Model
{
    protected $table = 'partner_profit';
    protected $fillable = ['partner_id','value'];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}

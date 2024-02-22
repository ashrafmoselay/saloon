<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class MovementInvoice extends Model
{
    protected $table = 'movement_invoice';
    protected $fillable = ['note','created_at','creator_id'];

    public function detailes(){
        return $this->hasMany(Movement::class,'invoice_id','id');
    }
    public function creator(){
        return $this->belongsTo(User::class,'creator_id','id');
    }
    protected static function boot()
    {
        parent::boot();
        // auto-sets values on creation
        if (Schema::hasColumn('movement_invoice', 'creator_id')) {
            static::creating(function ($query) {
                $query->creator_id = 1;//auth()->user()->id;
            });
        }
    }
}

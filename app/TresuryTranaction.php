<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class TresuryTranaction extends Model
{
    protected $table = 'tresury_tranactions';
    protected $fillable = ['note','value','type','record_id'];

	const TYPE_DEPOSITE = 'deposite';
	const TYPE_WITHDRAW = 'withdraw';
}

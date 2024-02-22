<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //use SoftDeletes;
    protected $table = 'senders';
    protected $fillable = ['sender_name','sender_mobile'];

}

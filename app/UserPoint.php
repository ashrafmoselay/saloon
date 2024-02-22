<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    protected $table = 'user_points';

    protected $fillable = ['user_id','balance','order_id'];

}

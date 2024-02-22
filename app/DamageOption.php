<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamageOption extends Model
{
    protected $table = 'damageoptions';
    protected $fillable = ['name'];

}

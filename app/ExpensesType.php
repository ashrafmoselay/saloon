<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesType extends Model
{
    use SoftDeletes;
    protected $table = 'expenses_type';
    protected $fillable = ['name'];
}

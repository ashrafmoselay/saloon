<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class SaleMeta extends Model
{
    protected $table = 'sales_meta';

    protected $fillable = ['target','work_days','percent','sale_id'];

    public function meta(){
        return $this->belongsTo(Person::class,'sale_id','id');
    }
}

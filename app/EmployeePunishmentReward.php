<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePunishmentReward extends Model
{
    use SoftDeletes;
    protected $table = 'employee_punishments_rewards';

    protected $fillable = ['employee_id','note','type','value'];
   
    public function employee(){
        return $this->belongsTo(Employee::class);
    }


}

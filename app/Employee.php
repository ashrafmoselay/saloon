<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'employees';
    protected $fillable = ['name','salary','day_salary','working_days','mobile','note','type','percent','manager_id','target'];
    protected $with = ['punishments','rewards','expenses','saleOrders','marketOrders'];


    public function punishments()
    {
        return $this->hasMany(EmployeePunishmentReward::class)->where('type','punishments');
    }

    public function rewards()
    {
        return $this->hasMany(EmployeePunishmentReward::class)->where('type','rewards');
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    public function manger(){
        return $this->belongsTo(Employee::class,'manager_id','id');
    }

    public function managerSalesEmployee(){
        return $this->hasMany(Employee::class,'manager_id','id');
    }

    public function saleOrders()
    {
        return $this->hasMany(Order::class,'sale_id','id');
    }
    public function paymentsTransactions()
    {
        return $this->hasMany(Transaction::class,'sale_id','id');
    }

    public function managerOrders()
    {
        return $this->hasMany(Order::class,'manager_id','id');
    }



    /*public function managerOrders(){
        return $this->hasManyThrough(Order::class,Employee::class,'manager_id','sale_id');
    }*/

    public function saleReturnsOrder()
    {
        return $this->hasMany(ReturnProduct::class,'sale_id','id');
    }

    public function marketOrders()
    {
        return $this->hasMany(Order::class,'markter_id','id');
    }


    public function totalProduct(){
        return $this->hasManyThrough(OrderDetail::class,Order::class, 'sale_id','order_id')
            ->selectRaw('product_id, SUM(qty) AS sum,unit_name,unit_id')
            ->groupBy('product_id','unit_id');
    }

    public function totalٌReturn(){
        return $this->hasManyThrough(ReturnDetail::class,ReturnProduct::class, 'sale_id','return_id')
            ->selectRaw('product_id, SUM(qty) AS sum')
            ->groupBy('product_id');
    }
    public function mtotalProduct(){
        return $this->hasManyThrough(OrderDetail::class,Order::class, 'manager_id','order_id')
            ->selectRaw('product_id, SUM(qty) AS sum,unit_name,unit_id')
            ->groupBy('product_id','unit_id');
    }

    public function mtotalٌReturn(){
        return $this->hasManyThrough(ReturnDetail::class,ReturnProduct::class, 'manager_id','return_id')
            ->selectRaw('product_id, SUM(qty) AS sum,unit_name,unit_id')
            ->groupBy('product_id','unit_id');
    }
    public function marketProduct(){
        return $this->hasManyThrough(OrderDetail::class,Order::class, 'markter_id','order_id')
            ->selectRaw('product_id,order_id, SUM(markter) AS sum')
            ->groupBy(['product_id','order_id']);
    }

}

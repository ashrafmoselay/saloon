<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected $fillable = [
        'name', 'type', 'percentage', 'percentage2',
        'half_percentage', 'percentage3'
    ];



    public function products()
    {
        return $this->hasMany(Product::class, 'main_category_id', 'id')
            ->where('is_service', 0);
    }

    public function productsservices()
    {
        return $this->hasMany(Product::class, 'main_category_id', 'id');
    }

    public function productsSubCategory()
    {
        return $this->hasMany(Product::class, 'sub_category_id', 'id')
            ->where('is_service', 0);
    }
    public function productsservicesSubCategory()
    {
        return $this->hasMany(Product::class, 'sub_category_id', 'id');
    }
}

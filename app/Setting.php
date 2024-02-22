<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'key', 'value'];

    public static function findByKey($key, $default = null)
    {
        $record = static::where('key', $key)->first();

        return $record ? $record->value : $default;
    }

}

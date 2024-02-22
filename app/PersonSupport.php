<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class PersonSupport extends Model
{
    protected $table = 'person_comments';

    protected $fillable = ['user_id', 'person_id','comment'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerStore extends Model
{
    protected $table = 'partner_stores';

    protected $fillable = ['percent','partner_id','store_id'];
}

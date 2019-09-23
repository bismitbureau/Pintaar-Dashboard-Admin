<?php

namespace Models\App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';

    protected $fillable = [
        'code', 'value', 'is_active'
    ];
}

<?php

namespace Models\App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'id_user', 'type', 'description', 'url', 'id_destination'
    ];
}

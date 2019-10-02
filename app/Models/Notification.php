<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'id_user', 'type', 'description', 'url', 'id_destination'
    ];
}

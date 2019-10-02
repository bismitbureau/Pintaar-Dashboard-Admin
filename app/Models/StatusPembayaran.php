<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPembayaran extends Model
{
    //

    protected $table = 'status_pembayarans';

    protected $fillable = [
        'status'
    ];

}

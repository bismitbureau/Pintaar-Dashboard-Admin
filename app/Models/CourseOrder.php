<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseOrder extends Model
{
    protected $table = 'pembelian_courses';

	protected $fillable = ['no_order', 'id_user', 'cart_id', 'status_pembayaran', 'metode_pembayaran', 'bukti_pembayaran'];

}

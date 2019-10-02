<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    //

    protected $table = 'murids';

    protected $fillable = [
        'id_user', 'asal_sekolah'
    ];

    public function pembelianCourse()
    {
        return $this->hasMany('App\PembelianCourse', 'id_murid');
    }
}

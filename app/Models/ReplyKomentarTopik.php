<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplyKomentarTopik extends Model
{
	protected $table = 'reply_komentar_topiks';

	public function user()
	{
	   return $this->hasOne('App\User','id','id_user');
	}
}

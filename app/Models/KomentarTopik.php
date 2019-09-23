<?php

namespace Models\App;

use Illuminate\Database\Eloquent\Model;

class KomentarTopik extends Model
{
  	protected $table = 'komentar_topiks';

    public function reply_komentar_topik()
	{
	   return $this->hasMany('App\ReplyKomentarTopik', 'id_komentar_topik','id')->orderBy('created_at', 'asc');
	}

  	public function user()
	{
	   return $this->hasOne('App\User','id','id_user');
	}


}

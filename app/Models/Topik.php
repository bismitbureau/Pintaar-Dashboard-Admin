<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{

  protected $table = 'topiks';

  protected $fillable = ['id_course', 'video', 'judul_topik', 'penjelasan', 'parent_id'];

  public function pertanyaanTopiks()
  {
    return $this->hasMany('App\PertanyaanTopik','id_topik');
  }

  public function topiks()
  {
    return $this->belongsTo("App\Course", "id_course");
  }

}

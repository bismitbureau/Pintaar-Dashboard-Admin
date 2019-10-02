<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class RatingCourse extends Model
{
    protected $table = 'rating_courses';

    protected $fillable = ['id_course', 'id_user', 'jumlah_rating'];

  	public function getUser()
  	{
    	return $this->hasOne('App\User', 'id', 'id_user');
  	}

  	public function storeRating($idCourse, $rating) {
		$this->id_user = Auth::user()->id;
		$this->id_course = $idCourse;
		$this->jumlah_rating = $rating;
		$this->save();
  	}
}

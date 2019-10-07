<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\RatingCourse;

class ReviewCourse extends Model
{
    protected $table = 'review_courses';

    protected $fillable = ['id_course', 'id_user', 'review'];

  	public function getUser()
  	{
    	return $this->hasOne('App\User', 'id', 'id_user');
  	}

  	public function storeReview($idCourse, $review) {
		$this->id_user = Auth::user()->id;
		$this->id_course = $idCourse;
		$this->review = $review;
		$this->save();
  	}

  	public function getRating($idCourse, $idUser)
  	{
    	$jumlahRating = RatingCourse::where('id_user', $idUser)->where('id_course', $idCourse)->first()->jumlah_rating;
    	return $jumlahRating;
  	}
}

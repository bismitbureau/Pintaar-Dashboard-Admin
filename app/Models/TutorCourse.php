<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
class TutorCourse extends Model
{
    protected $table = 'tutor_course';

    protected $fillable = ['course_id', 'tutor_id'];

	public function tutor()
	{
	   return $this->hasOne('App\Tutor', 'id', 'tutor_id');
	}

	public function store($request)
	{
		$profilePhoto     = $request->file('tutor_photo');
		$urlPhoto       = "";
		if ($profilePhoto != null) {
      $urlObject = Storage::disk('gcs')->put('course-photo', $profilePhoto);
      $urlPhoto =  'https://storage.googleapis.com/'.env('GOOGLE_CLOUD_STORAGE_BUCKET')."/".$urlObject;

		}

		if ($request->tutor_id == null) {
			$tutor = Tutor::create([
				"name"  => "Test",
				"profile_photo"  => $urlPhoto,
				"story"         => $request->deskripsi
			]);

			$tutorCourse = TutorCourse::create([
				"course_id"  => $request->course_id,
				"tutor_id"         => $tutor->id
			]);
		}
		else {
			$tutor = Tutor::where('id', $request->tutor_id)->first();
			$tutor->name = $request->tutor_name;
			$tutor->story = $request->deskripsi;

			if ($profilePhoto != null) {
				$tutor->profile_photo = $urlPhoto;
			}

			$tutor->save();
		}

		return $tutor;
	}
}

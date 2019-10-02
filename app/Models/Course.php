<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Tutor;
use App\Course;
use AbTesting;
use App\UserCourse;
use Auth;
use Carbon\Carbon;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['nama_course', 'harga', 'diskon', 'foto', 'deskripsi', 'id_tutor', 'video', 'kategori', 'isPublished'];

    public function creator()
    {
        return $this->hasOne('App\Tutor', 'id', 'id_tutor');
    }

    public function topiks()
    {
        return $this->hasMany('App\Topik', 'id_course');
    }

    public function tutors()
    {
        return $this->hasMany('App\TutorCourse', 'course_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\ReviewCourse', 'id_course');
    }

    public function ratings()
    {
        return $this->hasMany('App\RatingCourse', 'id_course');
    }

    public function getRating($idCourse)
    {
        $rating = DB::table('rating_courses')
            ->select(DB::raw('sum(jumlah_rating)/count(jumlah_rating) as rating'))
            ->where('rating_courses.id_course', $idCourse)
            ->get()->first();

        return $rating;
    }

    public function getReviews($idCourse)
    {


        $reviews = DB::table('review_courses')
            ->leftJoin('users', 'users.id', '=', 'review_courses.id_user')
            ->leftJoin('rating_courses', 'rating_courses.id_user', '=', 'review_courses.id_user')
            ->where('review_courses.id_course', $idCourse)
            ->where('rating_courses.id_course', $idCourse)
            ->orderByRaw('CHAR_LENGTH(review) desc')
            ->simplePaginate(5);


        return $reviews;
    }

    public function getReviewCount($idCourse)
    {
        $reviewCount = DB::table('review_courses')
                    ->where('review_courses.id_course', $idCourse)
                    ->count();
        return $reviewCount;
    }

    public function getEnrolledStudentNumber($idCourse)
    {
        $count_student_learned = DB::table('user_course')
            ->where('user_course.course_id', $idCourse)
            ->where('user_course.is_deleted', 0)
            ->count();
        return $count_student_learned;
    }

    public function getAllCourseByCategory($categoryID, $get_all = false)
    {

        $list_courses = DB::table('courses')
            ->select(DB::raw('sum(jumlah_rating)/count(jumlah_rating) as rating'), 'nama_course', 'users.nama', 'courses.id', 'harga', 'diskon', 'courses.foto', 'deskripsi', 'is_partner_class')
            ->leftJoin('tutors', 'courses.id_tutor', '=',  'tutors.id')
            ->leftJoin('users', 'users.id', '=', 'tutors.id_user')
            ->leftJoin('rating_courses', 'rating_courses.id_course', '=', 'courses.id')
            ->where('courses.kategori', $categoryID)
            ->where('courses.isPublished', 1)
            ->groupBy('courses.id', 'nama_course', 'users.nama', 'courses.id', 'harga', 'diskon', 'courses.foto', 'deskripsi', 'is_partner_class')
            ->orderBy('courses.created_at', 'asc');

        if ($get_all) {
            return $list_courses->get();
        } else {
            return $list_courses->take(8)->get();
        }
    }

    public function getStudentPaymentStatus($idCourse)
    {

        // for teacher
        if (Auth::user()->id_role == 2) {
            $tutor_own_course = DB::table('tutor_course')
                ->leftJoin('tutors', 'tutors.id', '=', 'tutor_course.tutor_id')
                ->where('tutors.id_user', Auth::user()->id)
                ->where('course_id', $idCourse)
                ->first();

            if ($tutor_own_course != null) {
                $status_pembayaran = new \stdClass();
                $status_pembayaran->status_pembayaran = 3;
                return $status_pembayaran;
            }
        }
        //for admin
        if (Auth::user()->id_role == 3) {
            $status_pembayaran = new \stdClass();
            $status_pembayaran->status_pembayaran = 3;
            return $status_pembayaran;
        }
        //for student
        //plz change this logic after we have great load for QA
        $user_course = UserCourse::where('course_id', $idCourse)
            ->where('user_id', Auth::user()->id)
            ->where('is_deleted', 0)
            ->first();

        if ($user_course != null &&
            ($user_course->date_limit_subscribe == NULL ||
            $user_course->date_limit_subscribe >= Carbon::today()->toDateString()
            )) {

            $status_pembayaran = new \stdClass();
            $status_pembayaran->status_pembayaran = 3;
            return $status_pembayaran;
        } else {
            $status_pembayaran = null;
        }

        return $status_pembayaran;
    }

    // check if student has reviewed a course
    public function getReviewStatus($idCourse)
    {
        $status_pernah_review = DB::table('review_courses')
            ->select('review')
            ->where('review_courses.id_user', Auth::user()->id)
            ->where('review_courses.id_course', $idCourse)
            ->get()->first();
        return $status_pernah_review;
    }

    ##DONT FORGET TO OPTIMAZE THIS LOGIC
    public function getRecommendedCourse($id)
    {
        $list_id_courses_bought[] = -1;

        if (!(Auth::guest())) {
            $user_id = Auth::user()->id;
            $courses_bought = UserCourse::where('course_id', $id)
                ->where('user_id', Auth::user()->id)
                ->where('is_deleted', 0)
                ->get();

            foreach ($courses_bought as $course_bought) {
                $list_id_courses_bought[] = $course_bought->course_id;
            }
        }

        $recommendedCourse = DB::table('courses')
            ->select(DB::raw('sum(jumlah_rating)/count(jumlah_rating) as rating'), 'nama_course', 'users.nama', 'courses.id', 'harga', 'diskon', 'courses.foto', 'deskripsi', 'is_partner_class')
            ->leftJoin('tutors', 'courses.id_tutor', '=',  'tutors.id')
            ->leftJoin('users', 'users.id', '=', 'tutors.id_user')
            ->leftJoin('rating_courses', 'rating_courses.id_course', '=', 'courses.id')
            ->where('isPublished', 1)
            ->whereNotIn('courses.id', $list_id_courses_bought)
            ->where('courses.id', '!=', $id)
            ->groupBy('courses.id', 'nama_course', 'users.nama', 'courses.id', 'harga', 'diskon', 'courses.foto', 'deskripsi', 'is_partner_class')
            ->get();

        $shuffled = $recommendedCourse->shuffle();
        $chunk = $shuffled->take(3);

        return $chunk;
    }
}

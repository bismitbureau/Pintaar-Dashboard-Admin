<?php

namespace Models\App;

use Auth;
use App\Cart;
use App\PembelianCourse;
use App\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Cookie;

class UserCourse extends Model
{
    protected $table = 'user_course';

	protected $fillable = ['user_id', 'course_id', 'is_deleted', 'date_limit_subscribe'];

	public function getCourse()
    {
        return $this->hasOne('App\Course','id', 'course_id');
    }

    public static function createOrUpdateUserCourseWithCartID(int $cart_id, int $user_id, int $is_deleted)
    {

        $cart_courses = (Cart::find($cart_id))->getCartCourses()->get();

        foreach ($cart_courses as $cart_course){

            $course_id = $cart_course->course_id;
            $course_subs_one_month = 75;
            $course_subs_two_month = 78;
            $course_subs_three_month = 79 ;
            $course_subs_six_month = 82;
            $course_subs_twelve_month = 83 ;

            if($course_id == $course_subs_one_month
                || $course_id == $course_subs_two_month
                || $course_id == $course_subs_three_month
                || $course_id == $course_subs_six_month
                || $course_id == $course_subs_twelve_month
            ){
                //add all course with date limit
                $all_courses = DB::table('courses')
                                ->where('isPublished', '=' , 1)
                                ->whereNull('is_partner_class')
                                ->get();

                foreach ($all_courses as $course) {

                    $user_course = UserCourse::where('user_id', '=' , $user_id)
                                            ->where('course_id', '=' , $course->id)
                                            ->where('is_deleted', '=' , 0)
                                            ->first();
                    //cek apakah pembelian course mau di extends atau perdana
                    // if pertama tentang jika ingin extends dari course itu, juga di cek apakah itu unlimited atau engga, jika unlimited atau null abaikan
                    // else jika ingin pembelian pertama
                    if($user_course != NULL && $user_course->date_limit_subscribe != NULL){

                            $date_limit_subscribe = Carbon::parse($user_course ->date_limit_subscribe) ;
                            //jika dia pas beli cuman tanggal pembelian nya lebih besar dari tanggal subs terakhir
                            if(Carbon::now() > $date_limit_subscribe){
                                $date_limit_subscribe =Carbon::now();

                            }
                            if($course_id == $course_subs_twelve_month){

                                $date_limit_subscribe = $date_limit_subscribe->addMonths(12);

                            }
                            else if($course_id == $course_subs_six_month){

                                $date_limit_subscribe = $date_limit_subscribe->addMonths(6);

                            }
                            else if($course_id == $course_subs_two_month){
                                $date_limit_subscribe = $date_limit_subscribe->addMonths(2);
                            }
                            else{
                                $date_limit_subscribe = $date_limit_subscribe->addMonths(1);
                            }
                            $user_course = UserCourse::updateOrCreate(
                                ['user_id' => $user_id, 'course_id' => $course->id],
                                ['is_deleted' => $is_deleted, 'date_limit_subscribe' => $date_limit_subscribe]
                            );

                    }
                    else if ($user_course == NULL) {
                        $date_limit_subscribe =null;

                        if($course_id == $course_subs_twelve_month){
                                $date_limit_subscribe =  Carbon::now()->addMonths(12);

                        }

                        else if($course_id == $course_subs_six_month){
                                $date_limit_subscribe =  Carbon::now()->addMonths(6);

                        }
                        else if($course_id == $course_subs_three_month){
                                $date_limit_subscribe =  Carbon::now()->addMonths(3);

                        }
                        else if($course_id == $course_subs_two_month){
                                $date_limit_subscribe =  Carbon::now()->addMonths(2);
                        }
                        else{
                            $date_limit_subscribe =  Carbon::now()->addMonths(1);
                        }
                        $user_course = UserCourse::updateOrCreate(
                            ['user_id' => $user_id, 'course_id' => $course->id],
                            ['is_deleted' => $is_deleted, 'date_limit_subscribe' => $date_limit_subscribe]
                        );
                    }


                }

            }
            else{
                $user_course = UserCourse::updateOrCreate(
                    ['user_id' => $user_id, 'course_id' => $course_id],
                    ['is_deleted' => $is_deleted, 'date_limit_subscribe' =>NULL]
                );
            }

        }

    }

    public static function getUserCourseWithDetail(){

      return DB::table('user_course')
          ->select('date_limit_subscribe' ,'nama_course','users.nama', 'courses.id', 'harga', 'courses.foto', 'deskripsi')
          ->leftJoin('courses', 'courses.id', '=', 'user_course.course_id')
          ->leftJoin('tutors', 'courses.id_tutor', '=',  'tutors.id')
          ->leftJoin('users', 'users.id', '=', 'tutors.id_user')
          ->where('user_course.user_id', Auth::user()->id)
          ->where('user_course.is_deleted', 0)
          ->get();

    }

    public static function getTotalUserJoinedCourse3DaysAgo(int $course_id){

        return DB::table('user_course')
            ->where('user_course.course_id', $course_id)
            ->where('user_course.is_deleted', 0)
            ->whereDate('user_course.created_at', '>=', Carbon::now()->subDays(3)->toDateString())
            ->count();
    }

    public static function getTotalUserJoinedAllCourseThisDay(){
        return DB::table('user_course')
            ->where('user_course.is_deleted', 0)
            ->whereDate('user_course.created_at', '=', Carbon::today()->toDateString())
            ->distinct()->get(['user_id'])
            ->count();
    }

    public static function getTotalUserJoinedAllCourse(){
        return DB::table('user_course')
            ->where('user_course.is_deleted', 0)
            ->distinct()->get(['user_id'])
            ->count();
    }

    public static function isNotSubscribeOrSubscribeLessThan1Month(int $user_id){

        $user_course = UserCourse::where('user_id', '=' , $user_id)
                                ->where('is_deleted', '=' , 0)
                                ->whereNotNull('date_limit_subscribe')
                                ->first();

        if($user_course != NULL){
            $subscribe_less_than_1_month =  Carbon::now()->addMonths(1) > Carbon::parse($user_course ->date_limit_subscribe);
            return $subscribe_less_than_1_month;
        }

        return true;

    }

    public static function isPopUpExtendsMustShow(int $user_id){
        if(UserCourse::isNotSubscribeOrSubscribeLessThan1Month($user_id)){
            $is_pop_up_extends_ever_shown = Cookie::get('is_pop_up_extends_ever_shown');
            if($is_pop_up_extends_ever_shown){
                return false;
            }
            else{
                $one_week_to_minutes = 10080;
                Cookie::queue('is_pop_up_extends_ever_shown', true, $one_week_to_minutes);
                return true;
            }
        }

        return false;

    }

}

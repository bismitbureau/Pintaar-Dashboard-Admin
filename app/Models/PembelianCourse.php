<?php

namespace Models\App;

use App\Cart;
use App\CartCourse;
use App\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class PembelianCourse extends Model
{

    protected $table = 'pembelian_courses';

    protected $fillable = ['no_order', 'id_user', 'cart_id', 'status_pembayaran', 'metode_pembayaran', 'bukti_pembayaran', 'pdf_url_midtrans', 'is_visible_on_transaction'];

    public function course()
    {
        return $this->hasOne('App\Course', 'id', 'id_course');
    }

    public function statusPembayaran()
    {
        return $this->hasOne('App\StatusPembayaran', 'id', 'status_pembayaran');
    }

    public function getUser()
    {
        return $this->hasOne('App\User', 'id', 'id_user');
    }

    public function getCart()
    {
        return $this->hasOne('App\Cart', 'id', 'cart_id');
    }

    public function getBoughtCoursesNames($cartID)
    {
        $cart_courses = (Cart::find($cartID))->getCartCourses()->get();
        $nama_course = "";
        foreach ($cart_courses as $cart_course){
            $nama_course = $nama_course.(Course::find($cart_course->course_id))->nama_course.', ';
        }

        return $nama_course;
    }


    public function getOrderPerCourse($courseId)
    {
        $orders = DB::table('pembelian_courses')
        ->select(DB::raw('users.nama as buyer_name'), DB::raw('cart_course.course_price as course_price'), DB::raw('cart_course.discount_percentage as discount_percentage'), DB::raw('pembelian_courses.created_at as order_time'))
        ->leftJoin('cart', 'cart.id', 'pembelian_courses.cart_id')
        ->leftJoin('cart_course', 'cart_course.cart_id', 'pembelian_courses.cart_id')
        ->leftJoin('users', 'users.id', 'pembelian_courses.id_user')
        ->where('pembelian_courses.status_pembayaran', 3)
        ->where('cart_course.course_id', $courseId)
        ->orderBy('pembelian_courses.created_at', 'desc')
        ->get();
        return $orders;
    }

    public function getRevenuePerCourse($courseId, $commisionPercentage)
    {
        $totalRevenue = 0;
        $orders = $this->getOrderPerCourse($courseId);
        foreach ($orders as $key => $order) {
            if ($order->course_price > 0 and $order->discount_percentage > 0) {
                $finalPrice = (100-$order->discount_percentage)/100*$order->course_price;
                $totalRevenue = $totalRevenue + $finalPrice;
            }
            else {
                $totalRevenue = $totalRevenue + $order->course_price;
            }
        }
        return $totalRevenue * $commisionPercentage;
    }


    public function getOrderPerCourseToday($courseId)
    {
        $orders = $this::leftJoin('cart_course', 'cart_course.cart_id', 'pembelian_courses.cart_id')
        ->where('pembelian_courses.status_pembayaran', 3)
        ->where('cart_course.course_id', $courseId)
        ->whereDate('pembelian_courses.created_at', Carbon::today())
        ->orderBy('pembelian_courses.created_at', 'desc')
        ->get();
        return $orders;
    }

    public function getOrderPerCourseThisWeek($courseId)
    {
        $orders = $this::leftJoin('cart_course', 'cart_course.cart_id', 'pembelian_courses.cart_id')
        ->where('pembelian_courses.status_pembayaran', 3)
        ->where('cart_course.course_id', $courseId)
        ->whereBetween('pembelian_courses.created_at',
                [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ])
        ->orderBy('pembelian_courses.created_at', 'desc')
        ->get();
        return $orders;
    }

    public function getOrderPerCourseThisMonth($courseId)
    {
        $orders = $this::leftJoin('cart_course', 'cart_course.cart_id', 'pembelian_courses.cart_id')
        ->where('pembelian_courses.status_pembayaran', 3)
        ->where('cart_course.course_id', $courseId)
        ->whereMonth('pembelian_courses.created_at', Carbon::now()->month)
        ->orderBy('pembelian_courses.created_at', 'desc')
        ->get();
        return $orders;
    }

    public function getRevenuePerCourseFromOrder($orders)
    {
        $totalRevenue = 0;
        foreach ($orders as $key => $order) {
            if ($order->course_price > 0 and $order->discount_percentage > 0) {
                $finalPrice = (100-$order->discount_percentage)/100*$order->course_price;
                $totalRevenue = $totalRevenue + $finalPrice;
            }
            else {
                $totalRevenue = $totalRevenue + $order->course_price;
            }
        }
        return $totalRevenue;
    }

}

<?php

namespace App\Models;

use App\CartCourse;
use App\Course;
use App\Cart;
use Illuminate\Database\Eloquent\Model;

class CartCourse extends Model
{
    protected $table = 'cart_course';

	protected $fillable = ['cart_id', 'course_id', 'course_price', 'discount_percentage'];

	public function getCourse()
    {
        return $this->hasOne('App\Course','id', 'course_id');
    }

    public function createCartCourse(Cart $cart, Course $course)
    {
        $cartCourse = CartCourse::create([
            'cart_id' => $cart->id,
            'course_id' => $course->id
        ]);
        return $cartCourse;
    }
}

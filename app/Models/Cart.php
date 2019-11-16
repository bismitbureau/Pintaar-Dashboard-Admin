<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\PembelianCourse;

class Cart extends Model
{
    protected $table = 'cart';

	protected $fillable = ['user_id', 'total_price', 'is_active'];

	public function getCartCourses()
    {
        return $this->hasMany('App\Models\CartCourse', 'cart_id');

    }

    public function showCurrentCart()
    {
        $cart = Cart::where('user_id', Auth::user()->id)
					->where('is_active', 1)
					->first();

		if ($cart == null) {
			return $cart;
		}
		else {
			$totalPrice = 0;

			foreach ($cart->getCartCourses as $course_in_cart) {
			  	$course_in_cart->course_price = $course_in_cart->getCourse->harga;
			  	$course_in_cart->discount_percentage = $course_in_cart->getCourse->diskon;
			  	$course_in_cart->update();

			  	if ($course_in_cart->getCourse->diskon != null and $course_in_cart->getCourse->diskon > 0) {
			  		$priceAfterDiscount = (100-$course_in_cart->getCourse->diskon) / 100*$course_in_cart->getCourse->harga;

			  		$totalPrice += $priceAfterDiscount;
			  	}
			  	else {
			  		$totalPrice += $course_in_cart->getCourse->harga;
			  	}

			}

			$cart->update(['total_price' => $totalPrice]);

			return $cart;
		}

    }
    public function totalBoughtCourse(){
        $cart = Cart::where('user_id', Auth::user()->id)
					->where('is_active', 1)
					->first();
        $totalBoughtCourse = 0;
        foreach ($cart->getCartCourses as $course_in_cart){
            $totalBoughtCourse++;
        }
         return $totalBoughtCourse;
    }

}

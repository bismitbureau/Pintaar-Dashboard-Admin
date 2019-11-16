<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartCourseTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(0,2000) as $i){
            DB::table('cart_course')->insert([
                'cart_id' => $faker->numberBetween($min=1, $max=2000),
                'course_id' => $faker->numberBetween($min=1, $max=2000),
                'course_price' => $faker->boolean(80) ? $faker->numberBetween($min=10000, $max=500000) : 0,
                'discount_percentage' => $faker->numberBetween($min=0, $max=100),
                'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
            ]);
        }
    }
}

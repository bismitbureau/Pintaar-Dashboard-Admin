<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(0,2000) as $i){
            DB::table('cart')->insert([
                'user_id' => $faker->numberBetween($min=1, $max=1000),
                'total_price' => $faker->boolean(80) ? $faker->numberBetween($min=10000, $max=500000) : 0,
                'is_active' => $faker->numberBetween($min=0, $max=1),
                'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
            ]);
        }
    }
}

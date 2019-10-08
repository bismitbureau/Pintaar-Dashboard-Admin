<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PembelianCourseTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(0,2000) as $i){
            DB::table('pembelian_courses')->insert([
                'id_user' => $faker->numberBetween($min=1, $max=1000),
                'no_order' => $faker->numberBetween($min=1, $max=1000),
                'cart_id' => $faker->numberBetween($min=1, $max=2000),
                'status_pembayaran' => $faker->numberBetween($min=0, $max=1),
                'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
            ]);
        }
    }
}

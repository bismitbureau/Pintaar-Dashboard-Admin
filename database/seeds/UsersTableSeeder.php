<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        foreach(range(0,1000) as $i){
            DB::table('users')->insert([
                'nama' => $faker->name,
                'email' => $faker->email,
                'alamat' => $faker->address,
                'password' => bcrypt('password'),
                'foto' => 'foto',
                'id_role' => 'user',
                'channel_acquisition' => 'channel_acquisition',
                'ab_temp_variant' => 1,
                'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
            ]);
        }
    }
}

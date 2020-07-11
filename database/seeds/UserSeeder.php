<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $user_seeder_array = [];

        for($i = 0;$i <= 100 ; $i++){
            $create_update_date = $faker->dateTime;
            $user_seeder_array[] = [
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make(Str::random(16)),
                'created_at' => $create_update_date,
                'updated_at' => $create_update_date
            ];
        }
        User::insert($user_seeder_array);
    }
}

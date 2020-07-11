<?php

use Illuminate\Database\Seeder;
use App\Event;
use App\User;
use Illuminate\Support\Str;

// Using model becose all time i will be use Model , no DB

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $events_seed_array = [];
        for( $i= 0 ; $i < 1200 ; $i++ ){
            $user = User::all()->random();
            $title = $faker->sentence;
            $create_update_date = $faker->dateTime();
            $slug = Str::slug($title , '-');
            $count_for_unique = 1;

            while(Event::where( 'slug' , $slug)->first()){
                $slug = $slug.'-'.$count_for_unique;
                $count_for_unique++;
            }

            $events_seed_array[] = [
                'title' => $title,
                'slug' => $slug,
                'description' => $faker->paragraph,
                'creator_id' => $user->id,
                'creator_name' => $user->name,
                'created_at'  => $create_update_date,
                'updated_at' => $create_update_date
            ];
        }
        Event::insert($events_seed_array);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Event;
use App\EventRelationShip;

class RelationShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relationship_array = [];
        for( $i = 0 ; $i <= 120 ; $i++ ){
            $user_id = User::all()->random();
            $relationship_array[] = [
                'user_id'  => User::all()->random()->id,
                'event_id' => Event::all()->random()->id
            ];
        }
        EventRelationShip::insert($relationship_array);
    }
}

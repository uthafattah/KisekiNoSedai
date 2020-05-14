<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sender = array('User', 'Store');

    	for ($i=6; $i <= 25; $i++) { //User
            $faker = Faker::create('id_ID');
        	for ($j=0; $j < 5; $j++) { //Store
                $store = $faker->unique()->numberBetween(1, 15);
                for ($k=0; $k < 10; $k++) { //Message
                    if($k == 0) {
                        DB::table('messages')->insert([
                            'user_id' => $i,
                            'store_id' => $store,
                            'sender' => $sender[0],
                            'messages' => $faker->text,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {
                        DB::table('messages')->insert([
                            'user_id' => $i,
                            'store_id' => $store,
                            'sender' => $sender[rand(0, 1)],
                            'messages' => $faker->text,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
    	}
            
    }
}

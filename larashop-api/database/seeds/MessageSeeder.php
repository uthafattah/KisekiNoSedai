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
        $faker = Faker::create('id_ID');
        $faker2 = Faker::create('cs_CZ');
        $sender = array('User', 'Store');

    	for ($i=0; $i < 1000; $i++) { 
        	$name = $faker2->name;
	        DB::table('messages')->insert([
                'user_id' => $faker->numberBetween(4, 103),
                'store_id' => $faker->numberBetween(1, 30),
	        	'sender' => $sender[mt_rand (0, 1)],
	        	'messages' => $faker2->text,
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

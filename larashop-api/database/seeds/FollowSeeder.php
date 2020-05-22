<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=6; $i <= 25; $i++) { //User
            $faker = Faker::create('id_ID');
            $follow = rand(5,10);
            for ($j=0; $j < $follow; $j++) { //Follow
    	        DB::table('follows')->insert([
    	        	'user_id' => $i,
                    'store_id' => $faker->unique()->numberBetween(1, 15),
    	        	'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
    	        ]);
            }
    	}
    }
}

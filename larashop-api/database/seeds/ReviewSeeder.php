<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for ($i=0; $i < 300; $i++) { 
	        DB::table('reviews')->insert([
	        	'order_id' => $faker->unique()->numberBetween(1, 300),
	        	'rating' => mt_rand (0, 50) / 10,
	        	'comment' => $faker->text,
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

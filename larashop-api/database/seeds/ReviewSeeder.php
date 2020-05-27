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

    	for ($i=0; $i < 400; $i++) { //Review
	        DB::table('reviews')->insert([
	        	'order_merchandise_id' => $faker->unique()->numberBetween(1, 400),
	        	'rating' => rand(1,5),
	        	'comment' => $faker->text,
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

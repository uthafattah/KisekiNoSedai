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

    	for ($i=0; $i < 200; $i++) { //Review
	        DB::table('reviews')->insert([
	        	'order_id' => $faker->unique()->numberBetween(1, 200),
	        	'rating' => rand(0,500) / 100,
	        	'comment' => $faker->text,
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

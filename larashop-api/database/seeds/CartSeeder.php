<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for ($i=0; $i < 100; $i++) { 
	        DB::table('carts')->insert([
	        	'user_id' => $faker->unique()->numberBetween(4, 103),
                'merchandise_id' => $faker->numberBetween(1, 150),
                'quantity' => $faker->numberBetween(1, 100),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 100; $i++) { 
	        DB::table('carts')->insert([
	        	'user_id' => $faker->unique()->numberBetween(4, 103),
                'merchandise_id' => $faker->numberBetween(1, 150),
                'quantity' => $faker->numberBetween(1, 100),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 100; $i++) { 
	        DB::table('carts')->insert([
	        	'user_id' => $faker->unique()->numberBetween(4, 103),
                'merchandise_id' => $faker->numberBetween(1, 150),
                'quantity' => $faker->numberBetween(1, 100),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

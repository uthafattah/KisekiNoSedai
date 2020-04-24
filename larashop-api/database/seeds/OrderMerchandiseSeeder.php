<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderMerchandiseSeeder extends Seeder
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
	        DB::table('order_merchandises')->insert([
	        	'order_id' => $faker->unique()->numberBetween(1, 300),
                'merchandise_id' => $faker->numberBetween(1, 150),
                'quantity' => $faker->numberBetween(1, 100),
	        	'note' => $faker->text,
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 300; $i++) { 
	        DB::table('order_merchandises')->insert([
	        	'order_id' => $faker->unique()->numberBetween(1, 300),
                'merchandise_id' => $faker->numberBetween(1, 150),
                'quantity' => $faker->numberBetween(1, 100),
	        	'note' => $faker->text,
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 300; $i++) { 
	        DB::table('order_merchandises')->insert([
	        	'order_id' => $faker->unique()->numberBetween(1, 300),
                'merchandise_id' => $faker->numberBetween(1, 150),
                'quantity' => $faker->numberBetween(1, 100),
	        	'note' => $faker->text,
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

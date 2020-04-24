<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
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
	        DB::table('orders')->insert([
	        	'user_id' => $faker->unique()->numberBetween(4, 103),
                'total_price' => '0',
                'invoice_number' => "INV-" . str_random(20),
                'status_order_id' => $faker->numberBetween(1, 7),
                'payment_id' => $faker->numberBetween(1, 8),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 100; $i++) { 
	        DB::table('orders')->insert([
	        	'user_id' => $faker->unique()->numberBetween(4, 103),
                'total_price' => '0',
                'invoice_number' => "INV-" . str_random(20),
                'status_order_id' => $faker->numberBetween(1, 7),
                'payment_id' => $faker->numberBetween(1, 8),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 100; $i++) { 
	        DB::table('orders')->insert([
	        	'user_id' => $faker->unique()->numberBetween(4, 103),
                'total_price' => '0',
                'invoice_number' => "INV-" . str_random(20),
                'status_order_id' => $faker->numberBetween(1, 7),
                'payment_id' => $faker->numberBetween(1, 8),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

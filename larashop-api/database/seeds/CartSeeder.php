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
    	for ($i=6; $i <= 25; $i++) { //User
            $faker = Faker::create('id_ID');
            $cart = rand(5,10);
            for ($j=0; $j < $cart; $j++) { //Cart
    	        DB::table('carts')->insert([
    	        	'user_id' => $i,
                    'merchandise_id' => $faker->unique()->numberBetween(1, 150),
                    'quantity' => rand(1,10),
    	        	'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
    	        ]);
            }
    	}
    }
}

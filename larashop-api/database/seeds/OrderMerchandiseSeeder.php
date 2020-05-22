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
    	for ($i=1; $i <= 200; $i++) { //Order
            $faker = Faker::create('id_ID');
            for ($j=0; $j < 2; $j++) { //Merchandise
    	        DB::table('order_merchandises')->insert([
    	        	'order_id' => $i,
                    'merchandise_id' => $faker->unique()->numberBetween(1, 150),
                    'quantity' => rand(1,10),
    	        	'note' => $faker->text,
    	        	'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
    	        ]);
            }
    	}
    }
}

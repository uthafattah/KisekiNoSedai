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
    	for ($i=6; $i <= 25; $i++) { //User
            for ($j=0; $j < 10; $j++) { //Order
    	        DB::table('orders')->insert([
    	        	'user_id' => $i,
                    'total_price' => '0',
                    'invoice_number' => "INV/" . strtoupper(str_random(2)) . "/" . strtoupper(str_random(3)) . "/" . rand(100000, 999999),
                    'status_order_id' => rand(1,7),
                    'payment_id' => rand(1,8),
    	        	'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
    	        ]);
            }
    	}
    }
}

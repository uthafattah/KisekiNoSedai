<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for ($i=0; $i < 6; $i++) { //Promo
	        DB::table('promos')->insert([
	        	'name' => "Promo Potongan " . (rand(1,10) * 5) . "% Special " . str_random(8) . " Terbatas!",
	        	'description' => $faker->text,
	        	'promo_code' => strtoupper(str_random(5)),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

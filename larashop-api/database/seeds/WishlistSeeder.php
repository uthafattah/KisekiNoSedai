<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WishlistSeeder extends Seeder
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
            $wishlist = rand(5,10);
            for ($j=0; $j < $wishlist; $j++) { //Wishlsit
    	        DB::table('wishlists')->insert([
    	        	'user_id' => $i,
                    'merchandise_id' => $faker->unique()->numberBetween(1, 150),
    	        	'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
    	        ]);
            }
    	}
    }
}

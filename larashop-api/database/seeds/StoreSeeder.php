<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $faker2 = Faker::create('fr_CH');

    	for ($i=0; $i < 15; $i++) { //Store
        	$name = $faker2->name;
	        DB::table('stores')->insert([
                'user_id' => $faker->unique()->numberBetween(6, 25),
	        	'name' => $name,
	        	'slug' => str_slug($name),
	        	'address' => $faker->address,
	        	'description' => $faker->text,
	        	'followers' => rand(0,25),
	        	'rating' => rand(10,50) / 10,
	        	'status_store_id' => rand(1,4),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

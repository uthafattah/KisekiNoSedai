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

    	for ($i=0; $i < 30; $i++) { 
        	$name = $faker2->name;
	        DB::table('stores')->insert([
                'user_id' => $faker->unique()->numberBetween(4, 103),
	        	'name' => $name,
	        	'slug' => str_slug($name),
	        	'address' => $faker2->address,
	        	'description' => $faker->text,
	        	'followers' => $faker->numberBetween(0, 100),
	        	'ratings' => mt_rand (0, 50) / 10,
	        	'status_store_id' => $faker->numberBetween(1, 4),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

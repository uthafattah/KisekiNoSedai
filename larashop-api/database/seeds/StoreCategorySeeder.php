<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for ($i=0; $i < 30; $i++) { 
	        DB::table('store_categories')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'category_id' => $faker->numberBetween(1, 28),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 30; $i++) { 
	        DB::table('store_categories')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'category_id' => $faker->numberBetween(1, 28),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');

    	for ($i=0; $i < 30; $i++) { 
	        DB::table('store_categories')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'category_id' => $faker->numberBetween(1, 28),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

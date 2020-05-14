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
    	for ($i=1; $i <= 15; $i++) { //Store
            $faker = Faker::create('id_ID');
            $category = rand(3,5);
            for ($j=0; $j < $category; $j++) { //Category
    	        DB::table('store_categories')->insert([
                    'store_id' => $i,
    	        	'category_id' => $faker->unique()->numberBetween(1, 28),
    	        	'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
    	        ]);
            }
    	}
    }
}

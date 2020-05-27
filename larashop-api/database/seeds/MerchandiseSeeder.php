<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MerchandiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$condition = array("New", "Secondhand");
    	$insurance = array("Yes", "No");

    	for ($i=1; $i <= 15; $i++) { //Store
    		$faker = Faker::create('id_ID');
    		$faker2 = Faker::create('en_US');
    		for ($j=0; $j < 10; $j++) { //Merchandise
	        	$name = $faker2->name;
		        DB::table('merchandises')->insert([
	                'store_id' => $i,
		        	'name' => $name,
		        	'slug' => str_slug($name),
		        	'description' => $faker->text,
		        	'stock' => rand(10,100),
		        	'price' => rand(10,10000) * 1000,
		        	'weight' => rand(1,100) * 100,
	        		'rating' => rand(10,50) / 10,
		        	'condition' => $condition[rand(0, 1)],
		        	'insurance' => $insurance[rand(0, 1)],
		        	'view_count' => rand(0,250),
		        	'created_at' => Carbon::now(),
	                'updated_at' => Carbon::now(),
		        ]);
		    }
    	}
    }
}

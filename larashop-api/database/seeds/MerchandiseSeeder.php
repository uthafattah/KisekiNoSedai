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
        $faker = Faker::create('id_ID');
        $faker2 = Faker::create('fr_CH');

    	for ($i=0; $i < 30; $i++) { 
        	$name = $faker2->name;
	        DB::table('merchandises')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'name' => $name,
	        	'slug' => str_slug($name),
	        	'description' => $faker->text,
	        	'stock' => $faker->numberBetween(50, 300),
	        	'price' => $faker->numberBetween(1, 10000) * 1000,
	        	'view_count' => $faker->numberBetween(0, 1000),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');
        $faker2 = Faker::create('fr_CH');

    	for ($i=0; $i < 30; $i++) { 
        	$name = $faker2->name;
	        DB::table('merchandises')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'name' => $name,
	        	'slug' => str_slug($name),
	        	'description' => $faker->text,
	        	'stock' => $faker->numberBetween(50, 300),
	        	'price' => $faker->numberBetween(1, 10000) * 1000,
	        	'view_count' => $faker->numberBetween(0, 1000),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');
        $faker2 = Faker::create('fr_CH');

    	for ($i=0; $i < 30; $i++) { 
        	$name = $faker2->name;
	        DB::table('merchandises')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'name' => $name,
	        	'slug' => str_slug($name),
	        	'description' => $faker->text,
	        	'stock' => $faker->numberBetween(50, 300),
	        	'price' => $faker->numberBetween(1, 10000) * 1000,
	        	'view_count' => $faker->numberBetween(0, 1000),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');
        $faker2 = Faker::create('fr_CH');

    	for ($i=0; $i < 30; $i++) { 
        	$name = $faker2->name;
	        DB::table('merchandises')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'name' => $name,
	        	'slug' => str_slug($name),
	        	'description' => $faker->text,
	        	'stock' => $faker->numberBetween(50, 300),
	        	'price' => $faker->numberBetween(1, 10000) * 1000,
	        	'view_count' => $faker->numberBetween(0, 1000),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}

    	$faker = Faker::create('id_ID');
        $faker2 = Faker::create('fr_CH');

    	for ($i=0; $i < 30; $i++) { 
        	$name = $faker2->name;
	        DB::table('merchandises')->insert([
                'store_id' => $faker->unique()->numberBetween(1, 30),
	        	'name' => $name,
	        	'slug' => str_slug($name),
	        	'description' => $faker->text,
	        	'stock' => $faker->numberBetween(50, 300),
	        	'price' => $faker->numberBetween(1, 10000) * 1000,
	        	'view_count' => $faker->numberBetween(0, 1000),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

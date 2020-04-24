<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = array('Requested', 'Waiting', 'On Process', 'Shipped', 'Arrived', 'Success', 'Canceled');

    	foreach ($name as $param) {
	        DB::table('status_orders')->insert([
	        	'name' => $param,
	        	'slug' => str_slug($param),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

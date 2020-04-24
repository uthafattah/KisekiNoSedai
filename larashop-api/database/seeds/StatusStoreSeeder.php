<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = array('Default', 'Verified Store', 'Starred Store', 'Official Store');

    	foreach ($name as $param) {
	        DB::table('status_stores')->insert([
	        	'name' => $param,
	        	'slug' => str_slug($param),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

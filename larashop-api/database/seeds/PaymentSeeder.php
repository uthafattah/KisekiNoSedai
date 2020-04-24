<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = array('Saldo Larashop', 'COD', 'ATM', 'GoPay', 'OVO', 'Dana', 'Alfamart', 'Indomart');

    	foreach ($name as $param) {
	        DB::table('payments')->insert([
	        	'name' => $param,
	        	'slug' => str_slug($param),
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

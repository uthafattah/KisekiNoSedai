<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	'name' => "Administrator",
        	'slug' => str_slug("Administrator"),
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
        	'name' => "Staff",
        	'slug' => str_slug("Staff"),
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
        	'name' => "Costumer",
        	'slug' => str_slug("Costumer"),
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

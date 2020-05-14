<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name' => "Mutashim Billah",
        	'email' => "mutashimb7@gmail.com",
        	'email_verified_at' => Carbon::now(),
        	'password' => bcrypt('password'),
        	'address' => "Bekasi",
        	'phone' => "081122334455",
        	'role_id' => "1",
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
        	'name' => "Muhammad Aidil Zartesya",
        	'email' => "aidilggwp@gmail.com",
        	'email_verified_at' => Carbon::now(),
        	'password' => bcrypt('password'),
        	'address' => "Pekanbaru",
        	'phone' => "080099887766",
        	'role_id' => "1",
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
        	'name' => "Abdul Fatah Kusnandar",
        	'email' => "uther@gmail.com",
        	'email_verified_at' => Carbon::now(),
        	'password' => bcrypt('password'),
        	'address' => "Tangerang",
        	'phone' => "081234567890",
        	'role_id' => "1",
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //-------------------------------------------------

        DB::table('users')->insert([
            'name' => "Muhammad Fuad Zikri",
            'email' => "fuadzikri@gmail.com",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'address' => "Riau",
            'phone' => "0800119922",
            'role_id' => "2",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => "Ahmad Rasyid Yusdi",
            'email' => "ahmedyusdi@gmail.com",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'address' => "Bogor",
            'phone' => "080987654321",
            'role_id' => "2",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //-------------------------------------------------

        $faker = Faker::create('id_ID');

        for ($i=0; $i < 20; $i++) { //User
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'role_id' => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

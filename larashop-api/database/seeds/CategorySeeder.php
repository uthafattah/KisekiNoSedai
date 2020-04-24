<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = array('Buku', 'Dapur', 'Elektronik', 'Fashion Anak', 'Fashion Muslim', 'Fashion Pria', 'Fashion Wanita', 'Film & Musik', 'Gaming', 'Handphone & Tablet', 'Ibu & Bayi', 'Kamera', 'Kecantikan', 'Kesehatan', 'Komputer & Laptop', 'Logam Mulia', 'Mainan & Hobi', 'Makanan & Minuman', 'Office & Stationery', 'Olahraga', 'Otomotif', 'Perawatan Hewan', 'Perawatan Tubuh', 'Perlengkapan Pesta', 'Pertukangan', 'Rumah Tangga', 'Wedding', 'Produk Lainnya');

    	foreach ($name as $param) {
	        DB::table('categories')->insert([
	        	'name' => $param,
	        	'slug' => str_slug($param),
	        	'photo' => "photos/" . str_slug($param) . ".png",
	        	'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
	        ]);
    	}
    }
}

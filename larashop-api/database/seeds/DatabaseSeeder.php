<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StatusStoreSeeder::class);
        $this->call(StatusOrderSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(PromoSeeder::class);
        //-----------------------------------
        $this->call(StoreSeeder::class);
        //-----------------------------------
        $this->call(StoreCategorySeeder::class);
        $this->call(MerchandiseSeeder::class);
        $this->call(MessageSeeder::class);
        //-----------------------------------
        $this->call(MerchandiseCategorySeeder::class);
        $this->call(WishlistSeeder::class);
        $this->call(FollowSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(OrderSeeder::class);
        //-----------------------------------
        $this->call(OrderMerchandiseSeeder::class);
        $this->call(ReviewSeeder::class);
    }
}

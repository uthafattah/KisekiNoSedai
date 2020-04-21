<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandise', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id')->unsigned();
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("photo")->default('photos/no_merchandise.png');;
			$table->text("description")->nullable();
			$table->double("stock")->nullable();
			$table->double("price")->nullable();
			$table->double("buy_count")->nullable();
			$table->double("view_count")->nullable();
			$table->double("wishlist_count")->nullable();
            $table->timestamps();
			
			$table->foreign('store_id')->references('id')->on('stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('merchandise', function(Blueprint $table){
            $table->dropForeign('merchandise_user_id_foreign');
        });
		
        Schema::dropIfExists('merchandise');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_categories', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('store_id')->references('id')->on('stores');
			$table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('store_categories', function(Blueprint $table){
            $table->dropForeign('store_categories_store_id_foreign');
			$table->dropForeign('store_categories_category_id_foreign');
        });
		
        Schema::dropIfExists('store_category');
    }
}

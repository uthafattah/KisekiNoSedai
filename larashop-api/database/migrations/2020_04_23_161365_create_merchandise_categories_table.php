<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchandiseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandise_categories', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('merchandise_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('merchandise_id')->references('id')->on('merchandises');
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
		Schema::table('merchandise_categories', function(Blueprint $table){
            $table->dropForeign('merchandise_categories_merchandise_id_foreign');
			$table->dropForeign('merchandise_categories_category_id_foreign');
        });
		
        Schema::dropIfExists('merchandise_categories');
    }
}

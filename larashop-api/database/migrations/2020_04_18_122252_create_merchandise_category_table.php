<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandiseCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandise_category', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('merchandise_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('merchandise_id')->references('id')->on('merchandise');
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
		Schema::table('merchandise_category', function(Blueprint $table){
            $table->dropForeign('merchandise_category_merchandise_id_foreign');
			$table->dropForeign('merchandise_category_category_id_foreign');
        });
		
        Schema::dropIfExists('merchandise_category');
    }
}

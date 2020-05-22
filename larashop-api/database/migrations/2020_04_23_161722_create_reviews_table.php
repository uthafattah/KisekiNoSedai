<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('order_merchandise_id')->unsigned();
			$table->decimal("rating")->nullable();
			$table->text('comment')->nullable();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('order_merchandise_id')->references('id')->on('order_merchandises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('reviews', function(Blueprint $table){
            $table->dropForeign('review_order_merchandise_id_foreign');
        });
		
        Schema::dropIfExists('reviews');
    }
}

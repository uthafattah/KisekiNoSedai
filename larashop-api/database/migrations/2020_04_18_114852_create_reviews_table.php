<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
			$table->integer('order_id')->unsigned();
			$table->decimal("rating")->unique();
			$table->string('comment')->nullable();
			$table->timestamps();
			
			$table->foreign('order_id')->references('id')->on('orders');
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
            $table->dropForeign('review_order_id_foreign');
        });
		
        Schema::dropIfExists('reviews');
    }
}

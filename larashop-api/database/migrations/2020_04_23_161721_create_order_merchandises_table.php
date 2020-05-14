<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_merchandises', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->integer('merchandise_id')->unsigned();
			$table->double("quantity")->default('1');
			$table->text("note")->nullable();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('merchandise_id')->references('id')->on('merchandises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('order_merchandises', function(Blueprint $table){
            $table->dropForeign('order_merchandises_order_id_foreign');
			$table->dropForeign('order_merchandises_merchandise_id_foreign');
        });
		
        Schema::dropIfExists('order_merchandises');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMerchandiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_merchandise', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->integer('merchandise_id')->unsigned();
			$table->double("quantity")->default('1');
			$table->string("note")->nullable();
			$table->timestamps();
			
			$table->foreign('order_id')->references('id')->on('users');
			$table->foreign('merchandise_id')->references('id')->on('merchandise');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('order_merchandise', function(Blueprint $table){
            $table->dropForeign('order_merchandise_order_id_foreign');
			$table->dropForeign('order_merchandise_merchandise_id_foreign');
        });
		
        Schema::dropIfExists('order_merchandise');
    }
}

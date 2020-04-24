<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
            $table->double("total_price");
            $table->string("invoice_number")->unique();
            $table->integer('status_order_id')->unsigned();
            $table->integer('payment_id')->unsigned();
			$table->timestamps();
			$table->softDeletes();
			
			$table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_order_id')->references('id')->on('status_orders');
			$table->foreign('payment_id')->references('id')->on('payments');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('orders', function(Blueprint $table){
            $table->dropForeign('orders_user_id_foreign');
			$table->dropForeign('orders_payment_id_foreign');
        });	
		
        Schema::dropIfExists('orders');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessengerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messenger', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('store_id')->unsigned();
            $table->enum("sender", ["User", "Store"]);
			$table->string('message');
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users');
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
		Schema::table('messenger', function(Blueprint $table){
            $table->dropForeign('messenger_sender_id_foreign');
			$table->dropForeign('messenger_receiver_id_foreign');
        });	
		
        Schema::dropIfExists('messenger');
    }
}

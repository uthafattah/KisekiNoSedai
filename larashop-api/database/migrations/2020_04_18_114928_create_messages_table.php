<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
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
		Schema::table('message', function(Blueprint $table){
            $table->dropForeign('message_sender_id_foreign');
			$table->dropForeign('message_receiver_id_foreign');
        });	
		
        Schema::dropIfExists('message');
    }
}

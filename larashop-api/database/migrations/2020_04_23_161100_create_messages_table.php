<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('store_id')->unsigned();
            $table->enum("sender", ["User", "Store"]);
			$table->text('messages');
			$table->timestamps();
			$table->softDeletes();
			
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
		Schema::table('messages', function(Blueprint $table){
            $table->dropForeign('messages_sender_id_foreign');
			$table->dropForeign('messages_receiver_id_foreign');
        });	
		
        Schema::dropIfExists('messages');
    }
}

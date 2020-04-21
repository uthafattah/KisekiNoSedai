<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("logo")->default('logos/no_logo.png');
			$table->text("address")->nullable();
			$table->string("description")->nullable();
			$table->double("followers")->nullable();
			$table->decimal("ratings")->nullable();
            $table->integer('status_store_id')->unsigned();
            $table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('status_store_id')->references('id')->on('status_store');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function(Blueprint $table){
            $table->dropForeign('store_user_id_foreign');
			$table->dropForeign('store_status_id_foreign');
        });		

        Schema::dropIfExists('stores');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->string('api_token', 80)->unique()->nullable()->default(null);
			$table->text("address")->nullable();
			$table->string("phone")->nullable();
            $table->string("avatar")->default('avatars/no_avatar.png');

            $table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles');
            
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('users', function(Blueprint $table){
            $table->dropForeign('users_role_id_foreign');
        });	
		
        Schema::dropIfExists('users');
    }
}

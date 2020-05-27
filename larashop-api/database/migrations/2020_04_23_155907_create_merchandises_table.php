<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandises', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('store_id')->unsigned();
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("photo")->default('photos/no_merchandise.png');;
			$table->text("description")->nullable();
			$table->double("stock")->nullable();
            $table->double("price")->nullable();
            $table->double("weight")->nullable();
            $table->decimal("rating")->nullable();
            $table->enum("condition", ["New", "Secondhand"]);
            $table->enum("insurance", ["Yes", "No"]);
			$table->double("view_count")->nullable();
            $table->timestamps();
			$table->softDeletes();
			
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
		Schema::table('merchandises', function(Blueprint $table){
            $table->dropForeign('merchandises_user_id_foreign');
        });
		
        Schema::dropIfExists('merchandises');
    }
}

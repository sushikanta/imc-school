<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateTmpcountriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('tmpcountries',function(Blueprint $table){
            $table->increments("id");
            $table->string("title")->nullable();
            $table->string("code")->nullable();
            $table->string("published")->nullable();
            $table->string("sort_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tmpcountries');
    }

}
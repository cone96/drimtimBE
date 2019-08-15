<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->bigIncrements('tweet_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('content');
            $table->timestamps();
        });

        

        Schema::table('tweets', function (Blueprint $table){		
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
        });
        Schema::enableForeignKeyConstraints();
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}

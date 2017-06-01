<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotFound extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('not_found', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('site_id')->default(1);
            $table->string('slug')->nullable();
            $table->string('redirect')->nullable();
            $table->string('referrer')->nullable();
            $table->integer('requests')->default(0);
            
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
        Schema::dropIfExists('not_found');
    }
}

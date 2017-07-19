<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('refrence')->nullable();
            $table->string('prepend_slug')->nullable();
            $table->string('view')->nullable();
            
            $table->timestamps();
            
            $table->index(['site_id'], 'site_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }
}

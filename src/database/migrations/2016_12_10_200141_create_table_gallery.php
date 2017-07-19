<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) 
        {
            $table->increments('id');

            $table->integer('site_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('filetype')->nullable()->default('image');
            $table->string('filename')->nullable();
            $table->string('extension')->nullable();
            $table->string('title')->nullable();
            $table->integer('filesize')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();

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
        Schema::dropIfExists('gallery');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('site_id');
            $table->integer('template_id');
            $table->string('prepend_slug')->nullable();
            $table->string('slug')->default('/');
            $table->string('language')->default('en');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('view')->nullable();
            $table->string('hash')->nullable();

            $table->timestamp('publish_at')->nullable();
            $table->timestamp('depublish_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['slug'], 'slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}

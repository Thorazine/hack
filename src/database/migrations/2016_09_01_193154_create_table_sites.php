<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('robots')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('protocol')->nullable();
            $table->string('domain')->nullable();
            $table->text('domains')->nullable();
            $table->string('language')->nullable();
            $table->text('languages')->nullable();
            $table->string('favicon')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_type')->nullable();
            $table->string('og_image')->nullable();
            $table->integer('browser_cache_time')->nullable()->default(300);
            $table->string('public_image_url')->nullable();

            $table->timestamp('publish_at')->nullable();
            $table->timestamp('depublish_at')->nullable();
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
        Schema::dropIfExists('sites');
    }
}

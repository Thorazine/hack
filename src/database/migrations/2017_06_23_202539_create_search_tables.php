<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) 
        {
            $table->tinyInteger('search_priority')->default(5)->after('view');
        });

        Schema::create('search_index', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('page_id');
            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->string('url')->nullable();
            $table->text('value')->nullable();
            $table->tinyInteger('search_priority');
            $table->timestamp('publish_date');
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
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['search_priority']);
        });

        Schema::dropIfExists('search_index');
    }
}

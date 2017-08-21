<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSlugs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slugs', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('site_id')->default(1);
            $table->integer('page_id')->nullable();
            $table->string('slug')->nullable();
            
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
        Schema::dropIfExists('slugs');
    }
}

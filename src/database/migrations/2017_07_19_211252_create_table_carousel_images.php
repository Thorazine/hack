<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCarouselImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousel_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carousel_id');
            $table->integer('image')->nullable();
            $table->integer('drag_order')->default(0)->nullable();
            $table->text('body')->nullable();
            $table->text('options')->nullable();
            $table->timestamps();

            $table->index(['drag_order'], 'drag_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carousel_images');
    }
}

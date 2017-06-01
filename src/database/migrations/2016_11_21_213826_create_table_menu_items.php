<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('menu_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('page_id')->nullable();
            $table->string('external_url')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->integer('depth')->default(0)->nullable();
            $table->integer('drag_order')->default(0)->nullable();
            $table->boolean('active')->default(1);
            
            $table->timestamps();

            $table->index(['menu_id'], 'menu_id');
            $table->index(['parent_id'], 'parent_id');
            $table->index(['depth'], 'depth');
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
        Schema::dropIfExists('menu_items');
    }
}

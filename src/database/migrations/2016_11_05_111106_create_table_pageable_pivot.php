<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePageablePivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pageables', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('page_id');
            $table->morphs('pageable');
            $table->integer('drag_order')->nullable()->default(10000);

            $table->index(['page_id', 'pageable_id'], 'pageable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pageables');
    }
}

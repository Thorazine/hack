<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTemplatePivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templateables', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('template_id');
            $table->morphs('templateable');
            $table->string('slug')->default('/');
            $table->integer('drag_order')->nullable()->default(10000);

            $table->index(['template_id', 'templateable_id', 'templateable_type'], 'templateable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templateables');
    }
}

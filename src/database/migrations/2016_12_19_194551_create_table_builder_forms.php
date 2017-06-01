<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBuilderForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builder_forms', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('template_sibling')->nullable();
            $table->string('key')->nullable();
            $table->string('label')->nullable();
            $table->string('value')->nullable();
            $table->string('default_value')->nullable();
            $table->string('create_regex')->nullable();
            $table->string('edit_regex')->nullable();
            
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
        Schema::dropIfExists('builder_forms');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFormValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_values', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('form_entry_id')->nullable();
            $table->integer('form_field_id')->nullable();
            $table->integer('form_id')->nullable();
            $table->text('value')->nullable();
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
        Schema::dropIfExists('form_values');
    }
}

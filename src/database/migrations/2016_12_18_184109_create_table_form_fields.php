<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFormFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('form_id')->nullable();
            $table->string('field_type')->nullable();
            $table->string('label')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('key')->nullable();
            $table->text('values')->nullable();
            $table->string('default_value')->nullable();
            $table->string('regex')->nullable();
            $table->string('width')->nullable();
            $table->boolean('overview')->nullable();
            $table->integer('drag_order')->default(10000);

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
        Schema::drop('form_fields');
    }
}

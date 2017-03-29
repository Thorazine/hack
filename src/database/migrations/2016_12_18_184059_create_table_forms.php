<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('title')->nullable();
            $table->string('email_template')->nullable();
            $table->string('button_text')->nullable();
            $table->string('on_complete_function')->nullable();
            $table->boolean('email_new')->nullable();
            $table->string('email_from')->nullable();
            $table->string('email_from_name')->nullable();
            $table->string('email_to')->nullable();
            $table->string('email_reply_to')->nullable();
            $table->string('email_reply_to_name')->nullable();
            $table->string('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->text('thank_message')->nullable();
            $table->string('download_as')->nullable();
            
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
        Schema::drop('forms');
    }
}

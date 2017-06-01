<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('site_id')->default(1);
            $table->integer('cms_user_id');
            $table->string('logged_session_id');
            $table->string('action')->nullable();
            $table->string('controller')->nullable();
            $table->text('request_data')->nullable();
            
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
        Schema::dropIfExists('logs');
    }
}

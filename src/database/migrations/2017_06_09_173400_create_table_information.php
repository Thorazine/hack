<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('site_id')->default(1);
            $table->string('sites')->nullable();
            $table->string('message_type')->nullable();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('depublish_at')->nullable();
            
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
        Schema::dropIfExists('information');
    }
}

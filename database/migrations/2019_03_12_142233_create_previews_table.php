<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previews', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('time')->nullable();
            $table->text('note')->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                                         ->on('users')
                                         ->onUpdate('cascade')
                                         ->onDelete('cascade');

            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')
                                         ->on('addresses')
                                         ->onUpdate('cascade')
                                         ->onDelete('cascade');
            
            $table->integer('preview_status_id')->unsigned()->nullable();
            $table->foreign('preview_status_id')->references('id')
                                         ->on('preview_statuses')
                                         ->onUpdate('cascade')
                                         ->onDelete('cascade'); 
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
        Schema::dropIfExists('previews');
    }
}

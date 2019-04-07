<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviewDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preview_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            
            $table->integer('preview_id')->unsigned();
            $table->foreign('preview_id')->references('id')
            ->on('previews')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')
            ->on('services')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->integer('governorate_id')->unsigned();
            $table->foreign('governorate_id')->references('id')
            ->on('governorates')
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
        Schema::dropIfExists('preview_dates');
    }
}

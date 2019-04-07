<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderInstallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_installations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warranty')->nullable();
            $table->string('warranty_start')->nullable();
            $table->string('warranty_end')->nullable();
            $table->double('price', 8, 3);
            $table->integer('qty');
            $table->double('total', 8, 3);
            $table->integer('installation_id')->unsigned();
            $table->foreign('installation_id')->references('id')->on('installations')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')
                  ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('order_installations');
    }
}

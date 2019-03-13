<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('lat')->nullable();
            $table->text('lang')->nullable();
            $table->text('block')->nullable();
            $table->text('street')->nullable();
            $table->text('building')->nullable();
            $table->text('floor')->nullable();
            $table->text('house_no')->nullable();
            $table->longText('address')->nullable();
            $table->text('note')->nullable();
            $table->integer('province_id')->unsigned()->nullable();
            $table->foreign('province_id')->references('id')
                                         ->on('provinces')
                                         ->onUpdate('cascade')
                                         ->onDelete('cascade');
                                         
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                                         ->on('users')
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
        Schema::dropIfExists('addresses');
    }
}

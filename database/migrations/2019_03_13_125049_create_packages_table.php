<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('months')->nullable();
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->double('price', 8, 3);
            $table->integer('status')->default(1);
            
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
        Schema::dropIfExists('packages');
    }
}

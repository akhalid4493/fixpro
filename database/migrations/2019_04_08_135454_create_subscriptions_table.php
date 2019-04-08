<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('start_at');
            $table->string('end_at');
            $table->double('total', 8, 3);

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                                         ->on('users')
                                         ->onUpdate('cascade')
                                         ->onDelete('cascade');

            $table->integer('package_id')->unsigned()->nullable();
            $table->foreign('package_id')->references('id')
                                         ->on('packages')
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
        Schema::dropIfExists('subscriptions');
    }
}

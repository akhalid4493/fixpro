<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionMonthliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_monthlies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('paid_at');
            $table->double('price', 8, 3);

            $table->integer('subscription_id')->unsigned();
            $table->foreign('subscription_id')->references('id')
                                         ->on('subscriptions')
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
        Schema::dropIfExists('subscription_monthlies');
    }
}

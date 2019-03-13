<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('slug');
            $table->integer('status')->default(1);
            $table->longText('description_en')->nullable();
            $table->longText('description_ar')->nullable();
            $table->longText('seo_description_en')->nullable();
            $table->longText('seo_description_ar')->nullable();
            $table->text('seo_keywords_en')->nullable();
            $table->text('seo_keywords_ar')->nullable();
            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('pages')
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
        Schema::dropIfExists('pages');
    }
}

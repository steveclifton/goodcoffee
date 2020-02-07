<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCafes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zomato_cafes', function (Blueprint $table) {
            $table->increments('cafeid');
            $table->string('service')->default('zomato');
            $table->string('name')->nullable();
            $table->string('apikey')->nullable();
            $table->integer('id')->nullable();
            $table->text('url')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('locality')->nullable();
            $table->string('city')->nullable();
            $table->string('city_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('zipcode')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('locality_verbose')->nullable();
            $table->string('cuisines')->nullable();
            $table->string('timings')->nullable();
            $table->string('averagecost')->nullable();
            $table->string('price_range')->nullable();
            $table->string('currency')->nullable();
            $table->text('highlights')->nullable();
            $table->decimal('zomato_rating')->nullable();
            $table->string('zomato_ratingtext')->nullable();
            $table->integer('zomato_votes')->nullable();
            $table->text('zomato_menuurl')->nullable();
            $table->text('zomato_image')->nullable();
            $table->text('zomato_thumb')->nullable();
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
        //
    }
}

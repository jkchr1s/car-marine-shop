<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehicleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_make_id')->unsigned();
            $table->foreign('vehicle_make_id')->references('id')->on('vehicle_makes');
            $table->string('model');
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
        Schema::drop('vehicle_models');
    }
}

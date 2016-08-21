<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleIdentificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_identifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->string('type');
            $table->string('number');
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
        Schema::drop('vehicle_identifications');
    }
}

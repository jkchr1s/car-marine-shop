<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id');
            $table->string('name');
            $table->string('description');
            $table->string('part_number');
            $table->string('serial_number');
            $table->string('notes');
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
        Schema::drop('vehicle_parts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
			$table->string('name',120);
			$table->string('car_image',255);
			$table->integer('year');
			$table->string('model',120);
			$table->string('color',120);
			$table->string('fuel_type',120);
			$table->float('mileage',10,2);
			$table->integer('seating_capacity');
			$table->integer('boot_space');
			$table->unsignedInteger('user_id');
            $table->timestamps();
			
			 $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}

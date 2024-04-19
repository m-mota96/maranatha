<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->integer('day')->length(10)->unsigned();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('meal_start_time')->nullable();
            $table->string('meal_end_time')->nullable();
            $table->integer('status')->length(10)->unsigned()->comment('[1=activo, 0=inactivo]');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_schedules');
    }
};

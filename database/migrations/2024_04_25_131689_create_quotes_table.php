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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Usuario que genera la cita');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('status_quote_id');
            $table->foreign('status_quote_id')->references('id')->on('status_quotes');
            $table->date('date')->comment('Fecha cita');
            $table->string('start_time', 10)->comment('Hora inicio cita');
            $table->string('end_time', 10)->nullable()->comment('Hora fin cita');
            $table->string('price')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};

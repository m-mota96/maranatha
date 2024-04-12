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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->nullable();
            $table->string('name', 300);
            $table->string('icon')->nullable();
            $table->string('target')->nullable();
            $table->string('class')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1)->comment('(1 = activo, 0 = inactivo)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};

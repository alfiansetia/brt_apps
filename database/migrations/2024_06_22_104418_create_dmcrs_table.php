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
        Schema::create('dmcrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('component_id');
            $table->enum('shift', ['day', 'night'])->default('day');
            $table->enum('type', ['schedule', 'unschedule'])->default('schedule');
            $table->date('date')->useCurrent();
            $table->dateTime('start')->useCurrent();
            $table->dateTime('finish')->useCurrent();
            $table->string('desc')->nullable();
            $table->string('action')->nullable();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('component_id')->references('id')->on('components')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dmcrs');
    }
};

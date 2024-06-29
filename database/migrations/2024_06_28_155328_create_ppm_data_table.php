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
        Schema::create('ppm_data', function (Blueprint $table) {
            $table->id();
            $table->date('date')->useCurrent();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('ppm_id')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('ppm_id')->references('id')->on('ppms')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppm_data');
    }
};

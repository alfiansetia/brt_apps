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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['S', 'M', 'L'])->default('S');
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->date('date')->useCurrent();
            $table->bigInteger('km')->default(0);
            $table->date('last_date')->nullable();
            $table->bigInteger('last_km')->default(0);
            $table->timestamps();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

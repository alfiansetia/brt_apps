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
        Schema::create('speed_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('speed_id');
            $table->unsignedBigInteger('unit_id');
            $table->bigInteger('value')->default(0);
            $table->timestamps();
            $table->foreign('speed_id')->references('id')->on('speeds')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speed_items');
    }
};

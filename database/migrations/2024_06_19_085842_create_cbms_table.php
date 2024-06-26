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
        Schema::create('cbms', function (Blueprint $table) {
            $table->id();
            $table->date('date')->useCurrent();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('component_id')->nullable();
            $table->bigInteger('km')->default(0);
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('component_id')->references('id')->on('components')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbms');
    }
};

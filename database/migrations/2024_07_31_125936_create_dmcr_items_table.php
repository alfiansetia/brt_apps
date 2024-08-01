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
        Schema::create('dmcr_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dmcr_id');
            $table->unsignedBigInteger('component_id')->nullable();
            $table->string('desc')->nullable();
            $table->string('action')->nullable();
            $table->string('part_number')->nullable();
            $table->string('part_name')->nullable();
            $table->integer('part_qty')->default(0);
            $table->foreign('dmcr_id')->references('id')->on('dmcrs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('component_id')->references('id')->on('components')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dmcr_items');
    }
};

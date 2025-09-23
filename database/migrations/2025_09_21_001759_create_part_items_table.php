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
        Schema::create('part_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('part_id');
            $table->string('image');
            $table->enum('type', ['new', 'old'])->default('old');
            $table->timestamps();
            $table->foreign('part_id')->references('id')->on('parts')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_items');
    }
};

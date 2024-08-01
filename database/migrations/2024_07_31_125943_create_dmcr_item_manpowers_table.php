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
        Schema::create('dmcr_item_manpowers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dmcr_item_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('dmcr_item_id')->references('id')->on('dmcr_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dmcr_item_manpowers');
    }
};

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
        Schema::create('logbook_manpowers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('logbook_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('logbook_id')->references('id')->on('logbooks')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_manpowers');
    }
};

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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->string('code');
            $table->enum('type', ['maxi', 'artic', 'low entry'])->default('maxi');
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};

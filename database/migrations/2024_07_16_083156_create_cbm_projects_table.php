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
        Schema::create('cbm_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pool_id');
            $table->string('pn')->nullable();
            $table->string('name')->nullable();
            $table->bigInteger('target')->default(0);
            $table->timestamps();
            $table->foreign('pool_id')->references('id')->on('pools')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbm_projects');
    }
};

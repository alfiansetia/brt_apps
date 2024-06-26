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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->useCurrent();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('component_id');
            $table->string('location')->nullable();
            $table->time('pre')->useCurrent();
            $table->time('start')->useCurrent();
            $table->time('finish')->useCurrent();
            $table->string('problem')->nullable();
            $table->string('action')->nullable();
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->string('desc')->nullable();
            $table->bigInteger('km_rfu')->default(0);
            $table->enum('respon', ['UT', 'TJ', 'MB'])->default('UT');
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('component_id')->references('id')->on('components')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};

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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->string('unit')->nullable();
            $table->string('sn')->nullable();
            $table->bigInteger('hm')->default(0);
            $table->bigInteger('km')->default(0);
            $table->date('start_date')->useCurrent();
            $table->date('finish_date')->useCurrent();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};

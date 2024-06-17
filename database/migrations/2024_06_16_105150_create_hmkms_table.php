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
        Schema::create('hmkms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->date('date')->useCurrent();
            $table->bigInteger('hm')->default(0);
            $table->bigInteger('km')->default(0);
            $table->bigInteger('hm_ac')->default(0);
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hmkms');
    }
};

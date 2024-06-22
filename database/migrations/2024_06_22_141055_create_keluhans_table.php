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
        Schema::create('keluhans', function (Blueprint $table) {
            $table->id();
            $table->date('date')->useCurrent();
            $table->string('name');
            $table->unsignedBigInteger('unit_id');
            $table->bigInteger('km')->default(0);
            $table->string('keluhan')->nullable();
            $table->decimal('r1', 12, 2)->default(0);
            $table->decimal('r2', 12, 2)->default(0);
            $table->decimal('r3_4', 12, 2)->default(0);
            $table->decimal('r5_6', 12, 2)->default(0);
            $table->decimal('r7_8', 12, 2)->default(0);
            $table->decimal('r9_10', 12, 2)->default(0);
            $table->enum('responsible', ['UT', 'MB'])->default('UT');
            $table->enum('status', ['pending', 'done'])->default('pending');
            $table->string('activity')->nullable();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhans');
    }
};

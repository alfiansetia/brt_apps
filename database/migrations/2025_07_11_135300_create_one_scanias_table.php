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
        Schema::create('one_scanias', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('unit')->nullable();
            $table->string('component')->nullable();
            $table->string('number')->nullable();
            $table->string('satuan_map')->nullable();
            $table->integer('price_map')->default(0);
            $table->string('satuan_vendor')->nullable();
            $table->integer('price_vendor')->default(0);
            $table->string('vendor')->nullable();
            $table->string('brand')->nullable();
            $table->string('remark')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_scanias');
    }
};

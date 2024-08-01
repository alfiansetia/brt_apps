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
        Schema::table('hmkms', function (Blueprint $table) {
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::table('oil_coolants', function (Blueprint $table) {
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::table('cbms', function (Blueprint $table) {
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::table('dmcrs', function (Blueprint $table) {
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::table('keluhans', function (Blueprint $table) {
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::table('speeds', function (Blueprint $table) {
            $table->unsignedBigInteger('pool_id')->nullable();
            $table->foreign('pool_id')->references('id')->on('pools')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hmkms', function (Blueprint $table) {
            $table->dropForeign(['pool_id']);
            $table->dropColumn('pool_id');
        });
        Schema::table('oil_coolants', function (Blueprint $table) {
            $table->dropForeign(['pool_id']);
            $table->dropColumn('pool_id');
        });
        Schema::table('cbms', function (Blueprint $table) {
            $table->dropForeign(['pool_id']);
            $table->dropColumn('pool_id');
        });
        Schema::table('dmcrs', function (Blueprint $table) {
            $table->dropForeign(['pool_id']);
            $table->dropColumn('pool_id');
        });
        Schema::table('keluhans', function (Blueprint $table) {
            $table->dropForeign(['pool_id']);
            $table->dropColumn('pool_id');
        });
        Schema::table('speeds', function (Blueprint $table) {
            $table->dropForeign(['pool_id']);
            $table->dropColumn('pool_id');
        });
    }
};

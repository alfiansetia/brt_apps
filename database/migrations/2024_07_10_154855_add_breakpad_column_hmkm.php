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
            $table->bigInteger('breakpad6')->default(0)->after('desc');
            $table->bigInteger('breakpad5')->default(0)->after('desc');
            $table->bigInteger('breakpad4')->default(0)->after('desc');
            $table->bigInteger('breakpad3')->default(0)->after('desc');
            $table->bigInteger('breakpad2')->default(0)->after('desc');
            $table->bigInteger('breakpad1')->default(0)->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hmkms', function (Blueprint $table) {
            $table->dropColumn('breakpad6');
            $table->dropColumn('breakpad5');
            $table->dropColumn('breakpad4');
            $table->dropColumn('breakpad3');
            $table->dropColumn('breakpad2');
            $table->dropColumn('breakpad1');
        });
    }
};

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
        Schema::table('dmcrs', function (Blueprint $table) {
            $table->integer('part_qty')->default(0)->after('action');
            $table->string('part_name')->nullable()->after('action');
            $table->string('part_number')->nullable()->after('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dmcrs', function (Blueprint $table) {
            $table->dropColumn('part_qty');
            $table->dropColumn('part_name');
            $table->dropColumn('part_number');
        });
    }
};

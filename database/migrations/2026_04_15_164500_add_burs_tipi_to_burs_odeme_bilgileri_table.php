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
        Schema::table('burs_odeme_bilgileri', function (Blueprint $table) {
            if (!Schema::hasColumn('burs_odeme_bilgileri', 'burs_tipi')) {
                $table->string('burs_tipi', 255);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('burs_odeme_bilgileri', function (Blueprint $table) {
            $table->dropColumn('burs_tipi');
        });
    }
};

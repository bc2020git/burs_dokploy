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
        Schema::table('tanim_burs_tipis', function (Blueprint $table) {
            if (!Schema::hasColumn('tanim_burs_tipis', 'ogrenim_tipi')) {
                $table->string('ogrenim_tipi', 32)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tanim_burs_tipis', function (Blueprint $table) {
            $table->dropColumn('ogrenim_tipi');
        });
    }
};

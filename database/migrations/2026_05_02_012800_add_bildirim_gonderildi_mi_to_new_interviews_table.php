<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('new_interviews', 'bildirim_gonderildi_mi')) {
            return;
        }

        Schema::table('new_interviews', function (Blueprint $table) {
            $table->enum('bildirim_gonderildi_mi', ['Evet', 'Hayir'])->default('Hayir')->after('uuid');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('new_interviews', 'bildirim_gonderildi_mi')) {
            return;
        }

        Schema::table('new_interviews', function (Blueprint $table) {
            $table->dropColumn('bildirim_gonderildi_mi');
        });
    }
};

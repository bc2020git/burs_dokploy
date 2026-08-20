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
        Schema::table('new_interviews', function (Blueprint $table) {
            $table->string('aday_katilim_durumu')->nullable(); // Katıldı, Katılmadı, Mazeretli
            $table->text('aday_katiliim_mazereti')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_interviews', function (Blueprint $table) {
            $table->dropColumn(['aday_katilim_durumu', 'aday_katiliim_mazereti']);
        });
    }
};

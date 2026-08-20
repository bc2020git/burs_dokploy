<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Katıldı -> Katılacağım
        DB::table('new_interviews')
            ->where('aday_katilim_durumu', 'Katıldı')
            ->update([
                'aday_katilim_durumu' => 'Katılacağım',
                'aday_katiliim_mazereti' => null,
            ]);

        // Katılmadı -> Katılmayacağım
        DB::table('new_interviews')
            ->where('aday_katilim_durumu', 'Katılmadı')
            ->update([
                'aday_katilim_durumu' => 'Katılmayacağım',
                'aday_katiliim_mazereti' => null,
            ]);

        // Mazeretli -> Başka bir tarihte...
        DB::table('new_interviews')
            ->where('aday_katilim_durumu', 'Mazeretli')
            ->update([
                'aday_katilim_durumu' => 'Başka bir tarihte ve/veya saatte katılmak istiyorum',
                'aday_katiliim_mazereti' => null,
            ]);
    }

    public function down(): void
    {
        // Best-effort rollback to old values (mazeret metni geri getirilemez).
        DB::table('new_interviews')
            ->where('aday_katilim_durumu', 'Katılacağım')
            ->update([
                'aday_katilim_durumu' => 'Katıldı',
                'aday_katiliim_mazereti' => null,
            ]);

        DB::table('new_interviews')
            ->where('aday_katilim_durumu', 'Katılmayacağım')
            ->update([
                'aday_katilim_durumu' => 'Katılmadı',
                'aday_katiliim_mazereti' => null,
            ]);

        DB::table('new_interviews')
            ->where('aday_katilim_durumu', 'Başka bir tarihte ve/veya saatte katılmak istiyorum')
            ->update([
                'aday_katilim_durumu' => 'Mazeretli',
                'aday_katiliim_mazereti' => null,
            ]);
    }
};


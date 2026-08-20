<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SLUG = 'mulakat-grubu-bildirimi';

    public function up(): void
    {
        DB::table('message_templates')->updateOrInsert(
            ['slug' => self::SLUG],
            [
                'title' => 'Mülakat Grubu Bildirimi',
                'content' => <<<'HTML'
<div style="font-family: arial, helvetica, sans-serif; color: #ffffff;">
    <p>Sayın _name_ _surname_</p>
    <p>Mülakat listeniz aşağıdaki gibidir.</p>
    _interview_table_
</div>
HTML,
                'parameters' => json_encode(['name', 'surname', 'interview_table'], JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('message_templates')->where('slug', self::SLUG)->delete();
    }
};

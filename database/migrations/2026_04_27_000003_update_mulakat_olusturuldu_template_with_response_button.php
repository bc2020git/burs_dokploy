<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SLUG = 'mulakat-olusturuldu-mesaji';
    private const PARAM = 'interview_response_url';
    private const START_MARK = '<!-- InterviewResponseButtonStart -->';
    private const END_MARK = '<!-- InterviewResponseButtonEnd -->';

    private function buttonHtml(): string
    {
        $href = '_'.self::PARAM.'_';

        return self::START_MARK."\n".<<<HTML
<div style="margin-top: 18px; margin-bottom: 6px;">
    <a href="{$href}" target="_blank" style="display: inline-block; background: #0d6efd; color: #ffffff; text-decoration: none; padding: 10px 14px; border-radius: 8px;">
        Katılım Durumunu Bildir
    </a>
</div>
<div style="font-size: 12px; color: #6c757d;">
    Bu bağlantı sadece mülakat katılım durumunuzu bildirmek içindir.
</div>
HTML
        ."\n".self::END_MARK;
    }

    public function up(): void
    {
        $row = DB::table('message_templates')->where('slug', self::SLUG)->first();
        if (! $row) {
            return;
        }

        $content = (string) ($row->content ?? '');
        $parametersRaw = $row->parameters ?? '[]';

        $params = [];
        if (is_string($parametersRaw) && $parametersRaw !== '') {
            $decoded = json_decode($parametersRaw, true);
            if (is_array($decoded)) {
                $params = $decoded;
            }
        } elseif (is_array($parametersRaw)) {
            $params = $parametersRaw;
        }

        if (strpos($content, self::START_MARK) === false) {
            $content = rtrim($content)."\n\n".$this->buttonHtml();
        }

        if (! in_array(self::PARAM, $params, true)) {
            $params[] = self::PARAM;
        }

        DB::table('message_templates')
            ->where('slug', self::SLUG)
            ->update([
                'content' => $content,
                'parameters' => json_encode(array_values($params), JSON_UNESCAPED_UNICODE),
            ]);
    }

    public function down(): void
    {
        $row = DB::table('message_templates')->where('slug', self::SLUG)->first();
        if (! $row) {
            return;
        }

        $content = (string) ($row->content ?? '');
        $parametersRaw = $row->parameters ?? '[]';

        // Remove injected block
        $startPos = strpos($content, self::START_MARK);
        $endPos = strpos($content, self::END_MARK);
        if ($startPos !== false && $endPos !== false && $endPos >= $startPos) {
            $endPos = $endPos + strlen(self::END_MARK);
            $content = trim(substr_replace($content, '', $startPos, $endPos - $startPos));
        }

        // Remove parameter key
        $params = [];
        if (is_string($parametersRaw) && $parametersRaw !== '') {
            $decoded = json_decode($parametersRaw, true);
            if (is_array($decoded)) {
                $params = $decoded;
            }
        } elseif (is_array($parametersRaw)) {
            $params = $parametersRaw;
        }

        $params = array_values(array_filter($params, fn ($p) => $p !== self::PARAM));

        DB::table('message_templates')
            ->where('slug', self::SLUG)
            ->update([
                'content' => $content,
                'parameters' => json_encode($params, JSON_UNESCAPED_UNICODE),
            ]);
    }
};


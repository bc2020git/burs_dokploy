<?php

namespace App\Models;

use App\Http\Controllers\MailController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class MessageTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'parameters',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'parameters' => 'array',
    ];

    /** Aday başvuru — toplu/tekil iade */
    public const SCENARIO_ADAY_IADE = 'aday_iade';

    /** Aday başvuru — toplu/tekil red */
    public const SCENARIO_ADAY_RED = 'aday_red';

    /** Kayıt yenileme — toplu/tekil iade */
    public const SCENARIO_KY_IADE = 'ky_iade';

    /** Kayıt yenileme — toplu/tekil red */
    public const SCENARIO_KY_RED = 'ky_red';

    public const DEFAULT_SLUG_ADAY_IADE = 'aday-iade-mesaji';

    public const DEFAULT_SLUG_ADAY_RED = 'aday-reddedildi';

    public const DEFAULT_SLUG_KY_IADE = 'kayit-yenileme-iade-edildi';

    public const DEFAULT_SLUG_KY_RED = 'kayit-yenileme-reddedildi';

    /** @deprecated Eski kod uyumu — SCENARIO_ADAY_IADE kullanın */
    public const DEFAULT_SLUG_IADE = self::DEFAULT_SLUG_ADAY_IADE;

    /** @deprecated Eski kod uyumu — SCENARIO_ADAY_RED kullanın */
    public const DEFAULT_SLUG_RED = self::DEFAULT_SLUG_ADAY_RED;

    private const TITLE_PREFIX = [
        self::SCENARIO_ADAY_IADE => 'Aday - Burs İade - ',
        self::SCENARIO_ADAY_RED => 'Aday - Burs Red - ',
        self::SCENARIO_KY_IADE => 'Kayıt Yenileme - Burs İade - ',
        self::SCENARIO_KY_RED => 'Kayıt Yenileme - Burs Ret - ',
    ];

    private const DEFAULT_SLUG_BY_SCENARIO = [
        self::SCENARIO_ADAY_IADE => self::DEFAULT_SLUG_ADAY_IADE,
        self::SCENARIO_ADAY_RED => self::DEFAULT_SLUG_ADAY_RED,
        self::SCENARIO_KY_IADE => self::DEFAULT_SLUG_KY_IADE,
        self::SCENARIO_KY_RED => self::DEFAULT_SLUG_KY_RED,
    ];

    /**
     * Sebep metnine göre şablon slug'ı. Başlık: "{prefix}{sebep}"; yoksa senaryonun varsayılan slug'ı.
     *
     * @param  string  $scenario  SCENARIO_* sabitlerinden biri
     */
    public static function resolveSlugForScenario(string $scenario, ?string $sebepText): string
    {
        if (! isset(self::DEFAULT_SLUG_BY_SCENARIO[$scenario])) {
            throw new InvalidArgumentException("Geçersiz şablon senaryosu: {$scenario}");
        }

        $default = self::DEFAULT_SLUG_BY_SCENARIO[$scenario];
        $trimmed = $sebepText !== null ? trim($sebepText) : '';

        if ($trimmed === '') {
            Log::info('MessageTemplate.resolveSlugForScenario', [
                'scenario' => $scenario,
                'sebep_text_raw' => $sebepText,
                'reason' => 'empty_sebep',
                'resolved_slug' => $default,
            ]);

            return $default;
        }

        // 1. Try Title matching first
        $prefix = self::TITLE_PREFIX[$scenario];
        $title = $prefix.$trimmed;
        $slug = static::where('title', $title)->value('slug');

        // 2. Try Slug-based matching with fallback to "diger"
        if (!$slug) {
            $slugPrefix = '';
            $digerSlug = '';
            if ($scenario === self::SCENARIO_ADAY_RED) {
                $slugPrefix = 'aday-burs-ret-';
                $digerSlug = 'aday-burs-ret-diger';
            } elseif ($scenario === self::SCENARIO_ADAY_IADE) {
                $slugPrefix = 'aday-burs-iade-';
                $digerSlug = 'aday-burs-iade-diger';
            } elseif ($scenario === self::SCENARIO_KY_RED) {
                $slugPrefix = 'kayit-yenileme-burs-ret-';
                $digerSlug = 'kayit-yenileme-burs-ret-diger';
            } elseif ($scenario === self::SCENARIO_KY_IADE) {
                $slugPrefix = 'kayit-yenileme-burs-iade-';
                $digerSlug = 'kayit-yenileme-burs-iade-diger';
            }

            if ($slugPrefix) {
                $proposedSlug = $slugPrefix . \Illuminate\Support\Str::slug($trimmed);
                if (static::where('slug', $proposedSlug)->exists()) {
                    $slug = $proposedSlug;
                } elseif ($digerSlug && static::where('slug', $digerSlug)->exists()) {
                    $slug = $digerSlug;
                }
            }
        }

        $resolved = $slug ?? $default;

        Log::info('MessageTemplate.resolveSlugForScenario', [
            'scenario' => $scenario,
            'sebep_text_raw' => $sebepText,
            'sebep_trimmed' => $trimmed,
            'searched_title' => $title,
            'slug_matched' => $slug,
            'default_slug' => $default,
            'resolved_slug' => $resolved,
            'used_default_fallback' => $slug === null,
        ]);

        return $resolved;
    }

    /**
     * @param  string  $scenario  SCENARIO_* sabitlerinden biri
     */
    public static function sendForSebepReason(
        MailController $mailController,
        string $scenario,
        ?string $sebepText,
        string $to,
        string $subject,
        array $parameters = []
    ): bool {
        $slug = static::resolveSlugForScenario($scenario, $sebepText);

        try {
            $ok = $mailController->sendTemplateEmail($slug, $to, $subject, $parameters);
            Log::info('MessageTemplate.sendForSebepReason', [
                'scenario' => $scenario,
                'sebep_text' => $sebepText,
                'slug_used' => $slug,
                'mail_ok' => $ok,
            ]);

            return $ok;
        } catch (\Throwable $e) {
            Log::error('MessageTemplate.sendForSebepReason_failed', [
                'scenario' => $scenario,
                'sebep_text' => $sebepText,
                'slug_attempted' => $slug,
                'exception' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}

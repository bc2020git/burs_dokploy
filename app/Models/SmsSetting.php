<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    use HasFactory;

    protected $table = 'sms_settings';

    protected $fillable = [
        'provider',
        'username',
        'password',
        'header',
        'balance',
        'is_active',
        'last_balance_check',
        'api_key',
        'secret_key'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_balance_check' => 'datetime',
    ];

    /**
     * Aktif SMS ayarlarını getir
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * NetGSM için gerekli ayarları döndür
     */
    public static function getNetGsmConfig()
    {
        $settings = self::where('provider', 'netgsm')
                       ->where('is_active', true)
                       ->first();

        if (!$settings) {
            throw new \Exception('NetGSM ayarları bulunamadı veya aktif değil.');
        }

        return [
            'usercode' => $settings->username,
            'password' => $settings->password,
            'header' => $settings->header,
        ];
    }

    /**
     * SMS bakiyesini güncelle
     */
    public function updateBalance($newBalance)
    {
        $this->balance = $newBalance;
        $this->last_balance_check = now();
        $this->save();
    }
}

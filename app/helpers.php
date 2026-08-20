<?php

namespace App\Helpers {


   
}

namespace {
    if (! function_exists('education_type_label')) {
        /**
         * Veritabanı / form anahtarlarını (örn. ilkokul) Excel ve raporlar için Türkçe etikete çevirir.
         */
        function education_type_label(?string $value): string
        {
            if ($value === null || trim($value) === '') {
                return '';
            }

            $map = [
                'ilkokul' => 'İlkokul',
                'ortaokul' => 'Ortaokul',
                'lise' => 'Lise',
                'onlisans' => 'Önlisans',
                'lisans' => 'Lisans',
                'yukseklisans' => 'Yükseklisans',
                'doktora' => 'Doktora',
            ];

            $key = strtolower(trim($value));

            return $map[$key] ?? $value;
        }
    }

    if (! function_exists('aday_timeline_log')) {
        /**
         * Aday zaman çizelgesi (new_timelines) log kaydı oluşturur.
         * Sütunlar: tc_no, topTitle, title, text, created_at
         *
         * @param  \DateTimeInterface|string|null  $createdAt  Belirtilmezse anlık zaman
         */
        function aday_timeline_log(
            string $tc_no,
            string $topTitle,
            string $title,
            string $text,
            $createdAt = null
        ): \App\Models\NewTimeline {
            $item = new \App\Models\NewTimeline();
            $item->tc_no = $tc_no;
            $item->topTitle = $topTitle;
            $item->title = $title;
            $item->text = $text;
            if ($createdAt !== null) {
                $item->created_at = $createdAt instanceof \DateTimeInterface
                    ? \Illuminate\Support\Carbon::instance($createdAt)
                    : \Illuminate\Support\Carbon::parse($createdAt);
            } else {
                $item->created_at = now();
            }
            $item->save();

            return $item;
        }
    }

    if (! function_exists('timeline_islem_yapan_for_request')) {
        /**
         * Web panel, aday veya bursiyer oturumundan işlem yapan ad soyad.
         */
        function timeline_islem_yapan_for_request(): string
        {
            $u = \Illuminate\Support\Facades\Auth::user()
                ?? \Illuminate\Support\Facades\Auth::guard('aday')->user()
                ?? \Illuminate\Support\Facades\Auth::guard('bursiyer')->user();

            return $u ? trim($u->name.' '.$u->surname) : 'Sistem';
        }
    }

    if (! function_exists('aday_timeline_dosya_yukleme')) {
        /**
         * Dosya / belge yükleme anında timeline kaydı (FormController vb. çağırabilir).
         */
        function aday_timeline_dosya_yukleme(string $tc_no, string $belgeEtiketi, ?string $period = null): \App\Models\NewTimeline
        {
            $actor = timeline_islem_yapan_for_request();
            $text = sprintf('%s belgesi yüklendi', $belgeEtiketi);
            if ($period !== null) {
                $text .= sprintf(' (%s)', $period);
            }
            $text .= sprintf('. İşlem yapan: %s', $actor);

            return aday_timeline_log(
                $tc_no,
                'Belge',
                'Dosya yükleme',
                $text
            );
        }
    }

    if (! function_exists('aday_timeline_belge_silme')) {
        /**
         * Belge / dosya silindiğinde timeline kaydı.
         */
        function aday_timeline_belge_silme(string $tc_no, string $belgeEtiketi, ?string $period = null): \App\Models\NewTimeline
        {
            $actor = timeline_islem_yapan_for_request();
            $text = sprintf('%s belgesi kaldırıldı', $belgeEtiketi);
            if ($period !== null) {
                $text .= sprintf(' (%s)', $period);
            }
            $text .= sprintf('. İşlem yapan: %s', $actor);

            return aday_timeline_log(
                $tc_no,
                'Belge',
                'Dosya silme',
                $text
            );
        }
    }

    if (! function_exists('aday_timeline_mail_gonderildi')) {
        /**
         * E-posta gönderildiğinde alıcı tc_no üzerinden timeline (MailController).
         */
        function aday_timeline_mail_gonderildi(string $tc_no, string $konu, ?string $ekNot = null): \App\Models\NewTimeline
        {
            $actor = timeline_islem_yapan_for_request();
            $text = sprintf('Konu: %s', $konu);
            if ($ekNot) {
                $text .= ' — '.$ekNot;
            }
            $text .= sprintf(' — İşlem yapan: %s', $actor);

            return aday_timeline_log($tc_no, 'E-posta', 'E-posta gönderildi', $text);
        }
    }

    if (! function_exists('aday_timeline_sms_gonderildi')) {
        /**
         * SMS gönderildiğinde alıcı tc_no üzerinden timeline.
         */
        function aday_timeline_sms_gonderildi(string $tc_no, string $ozet): \App\Models\NewTimeline
        {
            $actor = timeline_islem_yapan_for_request();

            return aday_timeline_log(
                $tc_no,
                'SMS',
                'SMS gönderildi',
                sprintf('%s — İşlem yapan: %s', $ozet, $actor)
            );
        }
    }
}

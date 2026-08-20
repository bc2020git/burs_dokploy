<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\IsSahipligi;
use App\Models\User;
use App\Models\Work;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttachmentMail;

class MessageController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
    }
    public function config(){
        $data = DB::table('mail_settings')->where('is_active',1)->first();
        $result = [
            'mail.mailers.smtp.transport' => $data->type,
            'mail.mailers.smtp.host' => $data->host,
            'mail.mailers.smtp.port' => $data->port,
            'mail.mailers.smtp.username' => $data->username,
            'mail.mailers.smtp.password' => $data->password,
            'mail.mailers.smtp.encryption' => $data->encryption,
            'mail.from.address' => $data->from_address,
            'mail.from.name' => $data->from_name
        ];
        return $result;
    }
        public function sendMail($konu, $alici, $mesaj, $files=null)
    {
        config($this->config());
        $tempFiles = [];

        // Mail içeriği
        $data = [
            'subject' => $konu,
            'alici' => $alici,
            'body' => $mesaj
        ];
        try {
            // Önce dosyaları geçici dizine kaydet
            if ($files) {
                $fileList = $files;
                if ($files instanceof \Illuminate\Http\UploadedFile) {
                    $fileList = [$files];
                }
                if (is_array($fileList)) {
                    foreach ($fileList as $file) {
                        if (!$file) { continue; }
                                                // Dosyayı direkt public path'e kaydet
                        $fileName = uniqid() . '_' . $file->getClientOriginalName();
                        $tempPath = public_path('uploads/temp/' . $fileName);

                        // Dizin yoksa oluştur
                        if (!file_exists(public_path('uploads/temp'))) {
                            mkdir(public_path('uploads/temp'), 0755, true);
                        }

                        // Dosyayı kopyala
                        $file->move(public_path('uploads/temp'), $fileName);

                        \Log::info('Dosya yolu kontrol', [
                            'file_exists' => file_exists($tempPath),
                            'file_size' => file_exists($tempPath) ? filesize($tempPath) : 0,
                            'file_permissions' => file_exists($tempPath) ? substr(sprintf('%o', fileperms($tempPath)), -4) : 'none'
                        ]);
                        $tempFiles[] = $tempPath;
                        \Log::info('Mail eki kaydedildi', ['path' => $tempPath]);
                    }
                }
            }

                        // Mail gönderme işlemi - Yeni Mailable class ile
            try {
                \Log::info('Mail gönderimi başlıyor', [
                    'alici' => $data['alici'],
                    'konu' => $data['subject'],
                    'ek_sayisi' => count($tempFiles)
                ]);

                // Attachment dosyalarını hazırla
                $attachmentFiles = [];
                foreach ($tempFiles as $tempFile) {
                    if (file_exists($tempFile)) {
                        $originalName = preg_replace('/^[a-f0-9]{13}_/', '', basename($tempFile));
                        $mimeType = mime_content_type($tempFile) ?: 'application/octet-stream';

                        $attachmentFiles[] = [
                            'path' => $tempFile,
                            'name' => $originalName,
                            'mime' => $mimeType
                        ];

                        \Log::info('Attachment hazırlandı', [
                            'original_name' => $originalName,
                            'temp_file' => $tempFile,
                            'mime_type' => $mimeType,
                            'file_size' => filesize($tempFile)
                        ]);
                    }
                }

                // Mailable class ile mail gönder
                $mail = new AttachmentMail($data['subject'], $data['body'], $attachmentFiles);
                $result = Mail::to($data['alici'])->send($mail);

                \Log::info('Mail gönderimi tamamlandı', [
                    'result' => $result,
                    'attachment_files_count' => count($attachmentFiles)
                ]);
            } catch (\Exception $e) {
                \Log::error('Mail gönderimi sırasında hata', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

            // Başarıyla mail gönderildiğinde, başarılı bir yanıt döndürün
        } catch (\Exception $e) {
            // Hata varsa, hata mesajını loglayın ve hata yanıtını döndürün
            Log::error('Mail gönderme hatası: ' . $e->getMessage());
            echo  $e->getMessage();
            // return redirect()->back()->with('error', $e->getMessage());
        } finally {
            // Geçici dosyaları temizle
            foreach ($tempFiles as $tempFile) {
                if (file_exists($tempFile)) {
                    unlink($tempFile);
                    \Log::info('Geçici dosya silindi', ['path' => $tempFile]);
                }
            }
            // Temp dizinini temizle
            $tempDir = storage_path('app/public/temp');
            if (file_exists($tempDir) && count(scandir($tempDir)) <= 2) {
                rmdir($tempDir);
                \Log::info('Temp dizini temizlendi');
            }
        }
    }}

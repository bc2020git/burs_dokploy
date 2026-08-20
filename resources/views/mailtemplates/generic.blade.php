<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $konu ?? 'Bilgilendirme' }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px;">
            <h2 style="color: #0056b3; margin-bottom: 20px;">{{ $konu ?? 'Bilgilendirme' }}</h2>
            
            <div style="margin-bottom: 20px;">
                {!! $content !!}
            </div>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666;">
                <p>Bu e-posta otomatik olarak gönderilmiştir. Lütfen bu e-postayı yanıtlamayınız.</p>
            </div>
        </div>
    </div>
</body>
</html> 
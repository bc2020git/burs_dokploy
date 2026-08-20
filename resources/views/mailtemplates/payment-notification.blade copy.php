<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Burs Ödemesi Bilgilendirmesi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <p>Sayın {{ $name }} {{ $surname }},</p>

        <p>{{ $donem }} dönemi {{ $burs_ayi }} ayı burs ödemeniz {{ $odeme_tutari }} TL tutarında 
        {{ $odeme_tarihi }} tarihinde hesabınıza aktarılmıştır.</p>

        <p>Bilgilerinize sunarız.</p>
        <p>İyi günler dileriz.</p>
    </div>
</body>
</html>

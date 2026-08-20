<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burs Modülü</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/loginPages/login-respon.css">
</head>
<body>
<div class="header-logo">
    <img src="../assets/images/logo-sm.svg" alt="digiCRM">

</div>
<div class="container-fluid">
    <div class="left-side"></div>
    <div class="right-side">
        <div class="form-container">
            <p class="subtitle">Bursiyer / Aday Bursiyer Girişi</p>
            <div class="chat-private-fill mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                </svg>
            </div>
            <form method="POST" action="{{ route('student.active.login.post') }}">
                @csrf                <div class="form-group">
                    <label for="email">E-posta Adresi</label>
                    <input required name='email' type="email" class="form-control" id="email" placeholder="Lütfen E-posta Adresinizi Giriniz">
                </div>
                <div class="form-group">
                    <label for="phone">Şifre</label>
                    <input required name='password' type="password" class="form-control" id="phone" placeholder="Lütfen Şifrenizi Giriniz">
                </div>
                <button type="submit" class="submit-btn">Giriş Yap </button>
                <a class='btn btn-secondary' href={{route('student-forgot-password')}}> Şifremi Unuttum  </a>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?=url('/')?>/resources/css/iziToast.min.css">
<script src="<?=url('/')?>/resources/js/iziToast.min.js" type="text/javascript"></script>
<script>
    @if(Session::has('error'))
    iziToast.error({
        timeout: 10000,
        messageSize: 18,
        title: 'Hata',
        message: '{{ Session::get('error') }}',
    });
    @endif
    @if(Session::has('success'))
    iziToast.success({
        timeout: 10000,
        messageSize: 18,
        title: 'İşlem Başarılı',
        message: '{{ Session::get('success') }}',
    });
    @endif
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

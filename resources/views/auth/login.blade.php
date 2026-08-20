<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burs Modülü</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('')}}/assets/css/loginPages/login-respon.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <style>
        #togglePassword{
            border: 0;
            border-bottom : 1px solid black;
        }
    </style>
</head>
<body>
<div class="header-logo">
    <img src="{{url('')}}/assets/images/logo-sm.svg" alt="digiCRM">
</div>
<div class="container-fluid">
    <div class="left-side"></div>
    <div class="right-side">
        <div class="form-container">
            <p class="title">Burs Modülü</p>
            <p class="subtitle">Yönetici Girişi</p>
            <div class="chat-private-fill mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M3 0C2.20435 0 1.44129 0.31607 0.87868 0.87868C0.31607 1.44129 0 2.20435 0 3V6C0 6.55228 0.447715 7 1 7C1.55228 7 2 6.55228 2 6V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2H6C6.55228 2 7 1.55228 7 1C7 0.447715 6.55228 0 6 0H3Z" fill="#2D3648"/>
                    <path d="M14 0C13.4477 0 13 0.447715 13 1C13 1.55228 13.4477 2 14 2H17C17.2652 2 17.5196 2.10536 17.7071 2.29289C17.8946 2.48043 18 2.73478 18 3V6C18 6.55228 18.4477 7 19 7C19.5523 7 20 6.55228 20 6V3C20 2.20435 19.6839 1.44129 19.1213 0.87868C18.5587 0.316071 17.7957 0 17 0H14Z" fill="#2D3648"/>
                    <path d="M2 14C2 13.4477 1.55228 13 1 13C0.447715 13 0 13.4477 0 14V17C0 17.7957 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20H6C6.55228 20 7 19.5523 7 19C7 18.4477 6.55228 18 6 18H3C2.73478 18 2.48043 17.8946 2.29289 17.7071C2.10536 17.5196 2 17.2652 2 17V14Z" fill="#2D3648"/>
                    <path d="M20 14C20 13.4477 19.5523 13 19 13C18.4477 13 18 13.4477 18 14V17C18 17.2652 17.8946 17.5196 17.7071 17.7071C17.5196 17.8946 17.2652 18 17 18H14C13.4477 18 13 18.4477 13 19C13 19.5523 13.4477 20 14 20H17C17.7957 20 18.5587 19.6839 19.1213 19.1213C19.6839 18.5587 20 17.7957 20 17V14Z" fill="#2D3648"/>
                </svg>
            </div>
            <form method="POST" action="{{ route('login') }}" class="auth-input">
                @csrf
                <div class="form-group">
                    <label for="email">E-posta Adresi</label>
                    <input required name="email" type="email" class="form-control" id="email" placeholder="Lütfen E-posta Adresinizi Giriniz">
                </div>
                <div class="form-group">
                    <label for="phone">Şifre</label>
                    <div class="input-group">
                        <input required name="password" type="password" class="form-control" id="phone" placeholder="Lütfen Şifrenizi Giriniz">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" id="eyeIcon">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M8 3.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9"/>
                                <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash d-none" viewBox="0 0 16 16" id="eyeSlashIcon">
                                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486z"/>
                                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                                <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button class="submit-btn" type="submit">Giriş Yap</button>
            </form>
        </div>
    </div>


</div>
<!-- Toastr CSS -->

<!-- Toastr JS --><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        toastr.error('{{ $error }}', 'Hata', {
        });
        @endforeach
    </script>

@endif

<!-- Scriptler -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('phone');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('d-none');
            eyeSlashIcon.classList.remove('d-none');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('d-none');
            eyeSlashIcon.classList.add('d-none');
        }
    });
</script>
</body>
</html>






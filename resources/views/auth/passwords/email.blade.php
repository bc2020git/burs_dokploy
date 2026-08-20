<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('public')}}/assets/css/loginPages/login.css">
    <link rel="stylesheet" href="{{url('public')}}/assets/css/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
<div class="container-fluid p-0">
    <div class="row g-0 vh-100">
        <div class="col-md-6 side-image d-none d-md-block">
        </div>

        <div class="col-md-6 right d-flex justify-content-center align-items-center">
            <div class="input-box">
                <div class="logo">
                    <img src="{{url('public')}}/assets/images/logo-sm.svg" alt="digiCRM">
                </div>
                <div class="turn-back">
                    <a href="{{route('login')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"
                                fill="#1A1A1A" />
                        </svg>
                        <span>Geri Dön</span>
                    </a>
                </div>
                <div class="otp-verify">
                    <header>Şifremi Unuttum</header>
                </div>
                <form method="POST" action="{{ route('password.update') }}"
                @csrf
                <div class="input-field-verify">
                    <div class="message-fill">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44"
                             fill="none">
                            <path
                                d="M11.8307 34.8333L3.66406 41.25V7.33333C3.66406 6.32082 4.48488 5.5 5.4974 5.5H38.4974C39.5099 5.5 40.3307 6.32082 40.3307 7.33333V33C40.3307 34.0126 39.5099 34.8333 38.4974 34.8333H11.8307ZM12.8307 18.3333V22H16.4974V18.3333H12.8307ZM20.1641 18.3333V22H23.8307V18.3333H20.1641ZM27.4974 18.3333V22H31.1641V18.3333H27.4974Z"
                                fill="#0065FF" />
                        </svg>
                    </div>
                    <div class="message">
                        <p>Mail adresine şifrenizi sıfırlayabilmeniz için bir link göndereceğiz.</p>
                    </div>
                    <div class="email-container">
                        <input type="email" id="email" name="email" class="email-input" placeholder="Mail adresinizi Giriniz.."
                               required>
                    </div>
                </div>
                <div class="input-field">
                    <a href=""><input type="submit" class="submit-btn" value="Gönder"></a>
                </div>
                </form>
                <div class="input-field-verify">
                    <span>Mail almadın mı? <a href="#">Tekrar gönder</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

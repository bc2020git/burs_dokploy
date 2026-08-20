<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/loginPages/login.css">
    <link rel="stylesheet" href="../assets/css/">
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
                    <img src="../assets/images/logo-sm.svg" alt="digiCRM">
                </div>
                <div class="turn-back">
                    <a href="{{route('student-forgot-password')}}">
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
                <div class="input-field-verify">
                    <div class="mail-unread-fill">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
                            <path d="M29.5141 5.49992C29.3938 6.09229 29.3307 6.70539 29.3307 7.33325C29.3307 7.96111 29.3938 8.57422 29.5141 9.16659H8.26841L22.1109 21.3803L31.3654 13.0925C32.1473 14.0595 33.1219 14.8643 34.2309 15.4485L22.129 26.2863L7.33073 13.2291V34.8333H36.6641V16.3165C37.2564 16.4368 37.8695 16.4999 38.4974 16.4999C39.1253 16.4999 39.7384 16.4368 40.3307 16.3165V36.6666C40.3307 37.6791 39.5099 38.4999 38.4974 38.4999H5.4974C4.48488 38.4999 3.66406 37.6791 3.66406 36.6666V7.33325C3.66406 6.32074 4.48488 5.49992 5.4974 5.49992H29.5141ZM38.4974 1.83325C41.535 1.83325 43.9974 4.29569 43.9974 7.33325C43.9974 10.3708 41.535 12.8333 38.4974 12.8333C35.4597 12.8333 32.9974 10.3708 32.9974 7.33325C32.9974 4.29569 35.4597 1.83325 38.4974 1.83325Z" fill="#0065FF"/>
                        </svg>
                    </div>
                    <div class="message">
                        <p>E-postanı kontrol et</p>
                        <p>Şifreni sıfırlayabilmen için {{ $email }} adresine bir mail gönderdik.</p>
                    </div>
                </div>
                <div class="input-field-unread">
                    <span>Mail almadın mı? <a onclick='location.reload();' href="#">Tekrar gönder</a></span>
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

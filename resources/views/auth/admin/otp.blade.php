<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Onaylama Formu</title>
    <link rel="stylesheet" href="{{ url('') }}/assets/css/loginPages/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0 vh-100">
            <div class="col-md-6 side-image d-none d-md-block"></div>

            <div class="col-md-6 right d-flex justify-content-center align-items-center">
                <div class="input-box">
                    <form method="POST" action="{{ route('admin.otp.verify') }}">
                        @csrf

                        <div class="logo">
                            <img src="{{ url('') }}/assets/images/logo-sm.svg" alt="logo">
                        </div>

                        <div class="turn-back">
                            <a href="{{ route('login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z"
                                        fill="#1A1A1A" />
                                </svg>
                                <span>Geri Dön</span>
                            </a>
                        </div>

                        <div class="otp-verify">
                            <header>OTP ile Doğrulama</header>
                        </div>

                        <div class="input-field-verify">
                            <div class="chat-private-fill">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M3 0C2.20435 0 1.44129 0.31607 0.87868 0.87868C0.31607 1.44129 0 2.20435 0 3V6C0 6.55228 0.447715 7 1 7C1.55228 7 2 6.55228 2 6V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2H6C6.55228 2 7 1.55228 7 1C7 0.447715 6.55228 0 6 0H3Z"
                                        fill="#2D3648" />
                                    <path
                                        d="M14 0C13.4477 0 13 0.447715 13 1C13 1.55228 13.4477 2 14 2H17C17.2652 2 17.5196 2.10536 17.7071 2.29289C17.8946 2.48043 18 2.73478 18 3V6C18 6.55228 18.4477 7 19 7C19.5523 7 20 6.55228 20 6V3C20 2.20435 19.6839 1.44129 19.1213 0.87868C18.5587 0.316071 17.7957 0 17 0H14Z"
                                        fill="#2D3648" />
                                    <path
                                        d="M2 14C2 13.4477 1.55228 13 1 13C0.447715 13 0 13.4477 0 14V17C0 17.7957 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20H6C6.55228 20 7 19.5523 7 19C7 18.4477 6.55228 18 6 18H3C2.73478 18 2.48043 17.8946 2.29289 17.7071C2.10536 17.5196 2 17.2652 2 17V14Z"
                                        fill="#2D3648" />
                                    <path
                                        d="M20 14C20 13.4477 19.5523 13 19 13C18.4477 13 18 13.4477 18 14V17C18 17.2652 17.8946 17.5196 17.7071 17.7071C17.5196 17.8946 17.2652 18 17 18H14C13.4477 18 13 18.4477 13 19C13 19.5523 13.4477 20 14 20H17C17.7957 20 18.5587 19.6839 19.1213 19.1213C19.6839 18.5587 20 17.7957 20 17V14Z"
                                        fill="#2D3648" />
                                </svg>
                            </div>

                            <div class="message">
                                <p>Lütfen 4 haneli doğrulama kodunu giriniz</p>
                                <p>{{ $email }} adresine bir mail gönderdik.</p>
                            </div>

                            <div class="otp-container">
                                <div class="otp-inputs">
                                    <input name="otp1" type="text" class="otp-input" maxlength="1" required>
                                    <input name="otp2" type="text" class="otp-input" maxlength="1" required>
                                    <input name="otp3" type="text" class="otp-input" maxlength="1" required>
                                    <input name="otp4" type="text" class="otp-input" maxlength="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-field-btn">
                            <input type="submit" id="submit-btn" class="submit" value="Giriş Yap" disabled
                                style="background-color: grey;">
                            <span>Mail almadın mı? <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('resend-form').submit();">Tekrar
                                    gönder</a></span>
                        </div>
                    </form>

                    <form id="resend-form" method="POST" action="{{ route('admin.otp.resend') }}" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('') }}/assets/js/loginPages/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const submitBtn = document.getElementById('submit-btn');

        function checkInputs() {
            const allFilled = Array.from(inputs).every(input => input.value !== '');
            if (allFilled) {
                submitBtn.disabled = false;
                submitBtn.style.backgroundColor = 'blue';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.backgroundColor = 'grey';
            }
        }

        inputs.forEach(input => {
            input.addEventListener('input', checkInputs);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const otpInputs = document.querySelectorAll(".otp-input");

            otpInputs.forEach((input, index) => {
                input.addEventListener("input", (event) => {
                    const value = event.target.value;
                    if (value.length === 1 && /^[0-9]$/.test(value)) {
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    } else {
                        event.target.value = "";
                    }
                });

                input.addEventListener("keydown", (event) => {
                    if (event.key === "Backspace" && !event.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
        });

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
</body>

</html>


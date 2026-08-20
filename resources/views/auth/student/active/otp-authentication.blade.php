<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Onaylama Formu</title>
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
                    <div class="turn-back"> <a href="/loginPages/index.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z" fill="#1A1A1A"/>
                          </svg>
                          <span>Geri Dön</span>
                    </a>
                    </div>

                    <div class="otp-verify"><header>OTP ile Doğrulama</header></div>
                    <div class="input-field-verify">
                        <div class="chat-private-fill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44" fill="none">
                                <path d="M21.9974 3.66675C32.1225 3.66675 40.3307 11.8749 40.3307 22.0001C40.3307 32.1252 32.1225 40.3334 21.9974 40.3334C18.8771 40.3334 15.9387 39.5539 13.3666 38.1789L3.66406 40.3334L5.82059 30.6345C4.44437 28.0616 3.66406 25.1219 3.66406 22.0001C3.66406 11.8749 11.8722 3.66675 21.9974 3.66675ZM21.9974 12.8334C19.0683 12.8334 16.4974 15.2901 16.4974 18.3334V20.1667H14.6641V29.3334H29.3307V20.1667H27.4974V18.3334C27.4974 15.2959 25.035 12.8334 21.9974 12.8334ZM25.6641 23.8334V25.6667H18.3307V23.8334H25.6641ZM21.9974 16.5001C22.8704 16.5001 23.8307 17.3984 23.8307 18.3334V20.1667H20.1641V18.3334C20.1641 17.3984 21.0573 16.5001 21.9974 16.5001Z" fill="#0065FF"/>
                              </svg>
                        </div>
                        <div class="message">
                            <p>Lütfen 4 haneli doğrulama kodunu giriniz</p>
                            <p>ahsen******@gmail.com adresine bir mail gönderdik.</p>
                        </div>
                        <div class="otp-container">
                            <div class="otp-inputs">
                                <input type="text" class="otp-input" maxlength="1" required>
                                <input type="text" class="otp-input" maxlength="1" required>
                                <input type="text" class="otp-input" maxlength="1" required>
                                <input type="text" class="otp-input" maxlength="1" required>
                            </div>
                        </div>

                    </div>
                    <div id="verifyButton" class="input-field-verify">
                        <a href="/studentRegistrationRenewalLogin/select-type.html"><input type="submit" class="submit-verify" value="Doğrula"></a>
                        <span>Mail almadın mı?  <a href="../loginPages/otp-authentication.html">Tekrar gönder</a></span>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/loginPages/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
<script >
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

    });</script>
</html>

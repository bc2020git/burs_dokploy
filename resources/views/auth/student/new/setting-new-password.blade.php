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
                        <a href="/loginPages//index.html">
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
                        <div class="lock-unlock-fill">
                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="38" viewBox="0 0 34 38" fill="none">
                                <path d="M7.83333 15.3334H31.6667C32.6792 15.3334 33.5 16.1542 33.5 17.1667V35.5001C33.5 36.5126 32.6792 37.3334 31.6667 37.3334H2.33333C1.32082 37.3334 0.5 36.5126 0.5 35.5001V17.1667C0.5 16.1542 1.32082 15.3334 2.33333 15.3334H4.16667V13.5001C4.16667 6.41243 9.91235 0.666748 17 0.666748C22.0243 0.666748 26.374 3.55388 28.4811 7.75959L25.2007 9.39972C23.6957 6.39566 20.5888 4.33341 17 4.33341C11.9374 4.33341 7.83333 8.43748 7.83333 13.5001V15.3334ZM13.3333 24.5001V28.1667H20.6667V24.5001H13.3333Z" fill="#0065FF"/>
                              </svg>
                        </div>
                        <div class="message">
                            <p>Lütfen yeni bir şifre belirleyiniz.</p>
                        </div>
                    </div>
                    <div class="password-reset-container">
                        <label for="new-password" class="form-label" id="form-label-password">Şifre</label>
                        <div class="password-input-group">
                            <input type="password" id="new-password" class="password-input" placeholder="Lütfen Şifrenizi Giriniz" required>
                            <button type="button" class="toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                    <path d="M11.9983 3.5C17.3904 3.5 21.8764 7.37976 22.8169 12.5C21.8764 17.6202 17.3904 21.5 11.9983 21.5C6.60617 21.5 2.1202 17.6202 1.17969 12.5C2.1202 7.37976 6.60617 3.5 11.9983 3.5ZM11.9983 19.5C16.2339 19.5 19.8583 16.552 20.7757 12.5C19.8583 8.44803 16.2339 5.5 11.9983 5.5C7.76265 5.5 4.13827 8.44803 3.22083 12.5C4.13827 16.552 7.76265 19.5 11.9983 19.5ZM11.9983 17C9.51303 17 7.49831 14.9853 7.49831 12.5C7.49831 10.0147 9.51303 8 11.9983 8C14.4835 8 16.4983 10.0147 16.4983 12.5C16.4983 14.9853 14.4835 17 11.9983 17ZM11.9983 15C13.379 15 14.4983 13.8807 14.4983 12.5C14.4983 11.1193 13.379 10 11.9983 10C10.6176 10 9.49831 11.1193 9.49831 12.5C9.49831 13.8807 10.6176 15 11.9983 15Z" fill="#8C8C8C"/>
                                  </svg>
                            </button>
                        </div>
                        <label for="confirm-password" class="form-label" id="form-label-password">Şifrenizi Yeniden Giriniz</label>
                        <div class="password-input-group">
                            <input type="password" id="confirm-password" class="password-input" placeholder="Lütfen Şifrenizi Yeniden Giriniz" required>
                            <button type="button" class="toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                                    <path d="M11.9983 3.5C17.3904 3.5 21.8764 7.37976 22.8169 12.5C21.8764 17.6202 17.3904 21.5 11.9983 21.5C6.60617 21.5 2.1202 17.6202 1.17969 12.5C2.1202 7.37976 6.60617 3.5 11.9983 3.5ZM11.9983 19.5C16.2339 19.5 19.8583 16.552 20.7757 12.5C19.8583 8.44803 16.2339 5.5 11.9983 5.5C7.76265 5.5 4.13827 8.44803 3.22083 12.5C4.13827 16.552 7.76265 19.5 11.9983 19.5ZM11.9983 17C9.51303 17 7.49831 14.9853 7.49831 12.5C7.49831 10.0147 9.51303 8 11.9983 8C14.4835 8 16.4983 10.0147 16.4983 12.5C16.4983 14.9853 14.4835 17 11.9983 17ZM11.9983 15C13.379 15 14.4983 13.8807 14.4983 12.5C14.4983 11.1193 13.379 10 11.9983 10C10.6176 10 9.49831 11.1193 9.49831 12.5C9.49831 13.8807 10.6176 15 11.9983 15Z" fill="#8C8C8C"/>
                                  </svg>
                            </button>
                        </div>
                    </div>
                    <div class="input-field">
                        <a href="password-changed.html"><input type="submit" class="submit" value="Şifreni Değiştir"></a>
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

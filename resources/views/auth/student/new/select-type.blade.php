<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eğitim Seçimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }

        .background-image {
            position: relative;
            width: 100%;
            height: 100vh;
            background-image: url('/assets/images/admin-bg.svg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .hidden {
            display: none;
        }

        .animate-spin {
    animation: spin 1s forwards;
}

@keyframes spin {
    100% {
        transform: rotate(360deg);
        opacity: 0;
    }
}


        #ortaogretim-btn,
        #yuksekogretim-btn {
            border-radius: 4px;
            border: 0.5px solid var(--Blue-500, #0E2087);
            background: var(--Black-100, #F2F2F2);
            display: flex;
            width: 300px;
            height: 72px;
            padding: 8px 12px;
            justify-content: center;
            align-items: center;
            gap: 4px;
            color: var(--Logo-Blue, #4069E5);
            text-align: center;
            font-size: 24px;
            font-style: normal;
            font-weight: 700;
            line-height: 150%;
        }

        .navbar-custom {
            color: #0E2087;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
        }
    </style>
</head>

<body>

    <div class="">
        <nav class="navbar navbar-expand px-4 py-3">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <span class="navbar-custom">Umut Yeşil</span>
                    </li>
                    <li class="nav-item">
                        <button class="btn border-2" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Bildirimler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M20 17H22V19H2V17H4V10C4 5.58172 7.58172 2 12 2C16.4183 2 20 5.58172 20 10V17ZM9 21H15V23H9V21Z"
                                    fill="#0E2087" />
                            </svg>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn border-2" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Tercihler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM11 15V17H13V15H11ZM13 13.3551C14.4457 12.9248 15.5 11.5855 15.5 10C15.5 8.067 13.933 6.5 12 6.5C10.302 6.5 8.88637 7.70919 8.56731 9.31346L10.5288 9.70577C10.6656 9.01823 11.2723 8.5 12 8.5C12.8284 8.5 13.5 9.17157 13.5 10C13.5 10.8284 12.8284 11.5 12 11.5C11.4477 11.5 11 11.9477 11 12.5V14H13V13.3551Z"
                                    fill="#0E2087" />
                            </svg>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn border-2" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Tercihler">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M8.68735 4.00008L11.294 1.39348C11.6845 1.00295 12.3177 1.00295 12.7082 1.39348L15.3148 4.00008H19.0011C19.5534 4.00008 20.0011 4.4478 20.0011 5.00008V8.68637L22.6077 11.293C22.9982 11.6835 22.9982 12.3167 22.6077 12.7072L20.0011 15.3138V19.0001C20.0011 19.5524 19.5534 20.0001 19.0011 20.0001H15.3148L12.7082 22.6067C12.3177 22.9972 11.6845 22.9972 11.294 22.6067L8.68735 20.0001H5.00106C4.44878 20.0001 4.00106 19.5524 4.00106 19.0001V15.3138L1.39446 12.7072C1.00393 12.3167 1.00393 11.6835 1.39446 11.293L4.00106 8.68637V5.00008C4.00106 4.4478 4.44878 4.00008 5.00106 4.00008H8.68735ZM12.0011 15.0001C13.6579 15.0001 15.0011 13.6569 15.0011 12.0001C15.0011 10.3432 13.6579 9.00008 12.0011 9.00008C10.3442 9.00008 9.00106 10.3432 9.00106 12.0001C9.00106 13.6569 10.3442 15.0001 12.0011 15.0001Z"
                                    fill="#0E2087" />
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="background-image">
            <div class="overlay">
                <div id="initial-buttons" class="btn-group">
                    <h1>Öğretim türünüzü seçiniz</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="ortaogretim-btn" class="btn btn-primary">ORTAÖĞRETİM</button>
                        </div>
                        <div class="col-md-6">
                            <button id="yuksekogretim-btn" class="btn btn-primary">YÜKSEK ÖĞRETİM</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ortaogretimBtn = document.getElementById("ortaogretim-btn");
            const yuksekogretimBtn = document.getElementById("yuksekogretim-btn");

            const addSpinAndRedirect = (button, url) => {
    button.addEventListener("click", function () {
        button.classList.add("animate-spin");
        setTimeout(() => {
            window.location.href = url;
        }, 1000);
    });
};

addSpinAndRedirect(ortaogretimBtn, '/studentLoginPages/type-middle.html');
addSpinAndRedirect(yuksekogretimBtn, '/studentLoginPages/type-high.html');

        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

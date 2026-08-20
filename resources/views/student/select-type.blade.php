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
            background-image: url({{url('public/assets/images/admin-bg.svg')}});
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


        @media (max-width: 768px) {
            #ortaogretim-btn,
            #yuksekogretim-btn {
                border-radius: 4px;
                border: 0.5px solid var(--Blue-500, #0E2087);
                background: var(--Black-100, #F2F2F2);
                display: flex;
                width: 100%; /* 300px yerine 100% yapıyoruz */
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
                margin: 0 auto; /* Ortalama için */
            }
            #initial-buttons {
                position: relative;
                width: 100%;
                padding-top: 100px; /* Başlık için üstte boşluk bırakıyoruz */
            }

            #initial-buttons h1 {
                position: fixed;
                top: 176px;
                left: 0;
                right: 0;
                text-align: center;
                background: rgba(0, 0, 0, 0.5);
                padding: 15px;
                margin: 0;
                z-index: 10;
            }

            #initial-buttons .row {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 2rem;
            }

            .col-md-6 {
                width: 100%;
                padding: 0 15px;
            }

            #ortaogretim-btn,
            #yuksekogretim-btn {
                width: 300px;
                margin: 0 auto;
            }
        }

        .navbar-custom {
            color: #0E2087;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: 150%;
        }

        @media (max-width: 768px) {
            #initial-buttons .row  .{
                justify-content: center;
            }
        }
    </style>
</head>

<body>

<div class="">
    @include('layouts.student.topbar-without-sidebar')<div class="row">

    <div class="background-image">
        <div class="overlay">
            @if(session('error'))
                <div style="position: absolute; z-index: 99" class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
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

        addSpinAndRedirect(ortaogretimBtn, '{{ route('get_education_type', ['tip' => 'Ortaogretim']) }}');
        addSpinAndRedirect(yuksekogretimBtn, '{{ route('get_education_type', ['tip' => 'YuksekOgretim']) }}');

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

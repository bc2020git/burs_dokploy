<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eğitim Seçimi</title>
    <link rel="stylesheet" href="{{url('public/assets/css/loginPages/student-login.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            body, html {
                margin: 0;
                padding: 0;

                min-height: 100vh;
            }

            .education-type {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 20px;
            }

            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                width: 100%;
                max-width: 300px;
                margin-top: 25px !important;
                margin-left: 36px !important;
            }

            .btn-group .btn {
                width: 100%;
                height: 72px;
                background: #4069E5;
                color: white;
                font-size: 20px;
                font-weight: 500;
                border: none;
                border-radius: 4px;
            }

            .education-type h3 {
                text-align: center;
                padding: 15px;
                width: 100%;
                position: fixed;
                top: 123px;
                left: 0;
                right: 0;
                background: rgba(128, 128, 128, 0.8);
                color: white;
                margin: 0;
                z-index: 10;
            }

            .col-md-6:last-child {
                display: none;
            }

            .education-type {
                padding-top: 120px;
            }

            .btn-group {
                gap: 2rem;
            }
        }
    </style>
</head>

<body>
@include('layouts.student.topbar-without-sidebar')
<div class="row">
    <div class="col-md-6">
        <div class="education-type">
            <h3>Öğretim türünüzü seçiniz</h3>
            <div class="btn-group mt-4">
                <button id="onlısans-btn" class="btn btn-primary">Ön Lisans</button>
                <button id="lısans-btn" class="btn btn-primary">Lisans</button>
                <button id="yuksek-btn" class="btn btn-primary">Yüksek Lisans</button>
                <button id="doktora-btn" class="btn btn-primary">Doktora</button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="background-image">
            <div class="overlay">
                <div id="initial-buttons" class="btn-group">
                    <button id="yuksekogretim-btn" class="btn btn-primary">YÜKSEK ÖĞRETİM</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const onlısansBtn = document.getElementById("onlısans-btn");
        const lısansBtn = document.getElementById("lısans-btn");
        const yuksekBtn = document.getElementById("yuksek-btn");
        const doktoraBtn = document.getElementById("doktora-btn");

        onlısansBtn.addEventListener("click", function () {
            window.location.href = '{{ route('get_scholarship_form', ['tip' => 'onlisans']) }}';
        });

        lısansBtn.addEventListener("click", function () {
            window.location.href = '{{ route('get_scholarship_form', ['tip' => 'lisans']) }}';
        });
        yuksekBtn.addEventListener("click", function () {
            window.location.href = '{{ route('get_scholarship_form', ['tip' => 'yukseklisans']) }}';
        });
        doktoraBtn.addEventListener("click", function () {
            window.location.href = '{{ route('get_scholarship_form', ['tip' => 'doktora']) }}';
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

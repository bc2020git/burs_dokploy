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
            margin-top:130px !important;
            margin-left: 72px !important;
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
        }


            .col-md-6:first-child {
                display: none;
            }

            .education-type {
                padding-top: 120px;
            }

            .education-type h3 {
                position: fixed;
                top: 176px;
                left: 0;
                right: 0;
                background: rgba(128, 128, 128, 0.8);
                color: white;
                margin: 0;
                z-index: 10;
            }

            .btn-group {
                gap: 2rem;
            }

            .btn-group .btn {
                background: #4069E5;
                color: white;
            }
        }
    </style>
</head>

<body>
@include('layouts.student.topbar-without-sidebar')<div class="row">
<div class="row">
    <div class="col-md-6">
        <div class="background-image">
            <div class="overlay">
                <div id="initial-buttons" class="btn-group">
                    <button id="ortaogretim-btn" class="btn btn-primary">ORTAÖĞRETİM</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="education-type">
            <h3>Öğretim türünüzü seçiniz</h3>
            <div class="btn-group mt-4">
                <button id="ılkokul-btn" class="btn btn-primary">İlkokul</button>
                <button id="ortaokul-btn" class="btn btn-primary">Ortaokul</button>
                <button id="lise-btn" class="btn btn-primary">Lise</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ılkokulBtn = document.getElementById("ılkokul-btn");
        const ortaokulBtn = document.getElementById("ortaokul-btn");
        const liseBtn = document.getElementById("lise-btn")

        ılkokulBtn.addEventListener("click", function () {
            window.location.href = '{{ route('get_scholarship_form', ['tip' => 'ilkokul']) }}';
        });

        ortaokulBtn.addEventListener("click", function () {
            window.location.href = '{{ route('get_scholarship_form', ['tip' => 'ortaokul']) }}';
        });
        liseBtn.addEventListener("click", function () {
            window.location.href = '{{ route('get_scholarship_form', ['tip' => 'lise']) }}';
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

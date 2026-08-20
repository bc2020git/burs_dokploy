@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('navbar-form')
    <form action="#" class="d-none d-sm-inline-block">
        <div class="input-group input-group-navbar">
        <span>SMS Ayarları</span>
        </div>
    </form>
@endsection
@section('page-title')
    SMS Ayarları
@endsection
@section('local-css')
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                    <div class="container">
                        <h2>SMS Ayarları</h2>
                        <div class=" mb-4">
                            <div class="card-body">
                                <form action="{{ route('sms.test') }}" method="POST" class="row g-3 align-items-center">
                                    @csrf
                                    <div class="col-auto">
                                        <input type="tel" class="form-control" id="test_phone" name="test_phone" placeholder="Test telefon numarası" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Test SMS Gönder</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form action="{{ route('sms.settings.update') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">NetGSM Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $smsSettings->username ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">NetGSM Şifre</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password', $smsSettings->password ?? '') }}">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="header" class="form-label">Başlık (Header)</label>
                                <input type="text" class="form-control" id="header" name="header" value="{{ old('header', $smsSettings->header ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label for="balance" class="form-label">SMS Bakiyesi</label>
                                <input type="text" class="form-control" id="balance" value="{{ $smsSettings->balance ?? '0' }}" readonly>
                                <small class="text-muted">Son kontrol: {{ $smsSettings->last_balance_check ? \Carbon\Carbon::parse($smsSettings->last_balance_check)->format('d.m.Y H:i:s') : 'Henüz kontrol edilmedi' }}</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
            </div>
        </main>



    @endsection

    @section('local-js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
        <script>
            $(document).ready(function() {
                // Şifre görünürlüğü kontrolü
                $('#togglePassword').on('click', function() {
                    alert('test');
                    const passwordInput = $('#password');
                    const toggleIcon = $('#toggleIcon');

                    // Şifre input tipini değiştir
                    if (passwordInput.attr('type') === 'password') {
                        passwordInput.attr('type', 'text');
                        toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        passwordInput.attr('type', 'password');
                        toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            });
        </script>
    @endsection

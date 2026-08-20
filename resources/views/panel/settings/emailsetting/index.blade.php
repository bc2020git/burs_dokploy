@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Mail Ayarları
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
                        <h2>Mail Ayarları</h2>
                        <div class=" mb-4">
                            <div class="card-body">
                                <form action="{{ route('mail.test') }}" method="POST" class="row g-3 align-items-center">
                                    @csrf
                                    <div class="col-auto">
                                        <input type="email" class="form-control" id="test_email" name="test_email" placeholder="Test e-posta adresi" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Test Maili Gönder</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <form action="{{ route('mail.settings.update') }}" method="POST">
                            @csrf
                            <div class="mb-3 ">
                                <label>Mail Tipi:</label>
                                <div class="d-flex">
                                @foreach(['smtp', 'useinbox', 'sendgrid'] as $type)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="{{ $type }}" value="{{ $type }}" {{ old('type', $mailSettings->where('is_active', true)->first()->type ?? '') == $type ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $type }}">
                                            {{ ucfirst($type) }}
                                        </label>
                                    </div>
                                @endforeach
                                </div>
                            </div>

                            <div id="smtp-settings" class="mail-settings">
                                <div class="mb-3">
                                    <label for="host" class="form-label">Host</label>
                                    <input type="text" class="form-control" id="host" name="host" value="{{ old('host', $mailSettings->where('type', 'smtp')->first()->host ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="port" class="form-label">Port</label>
                                    <input type="number" class="form-control" id="port" name="port" value="{{ old('port', $mailSettings->where('type', 'smtp')->first()->port ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Kullanıcı Adı</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $mailSettings->where('type', 'smtp')->first()->username ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Şifre</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password', $mailSettings->where('type', 'smtp')->first()->password ?? '') }}">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="encryption" class="form-label">Şifreleme</label>
                                    <input type="text" class="form-control" id="encryption" name="encryption" value="{{ old('encryption', $mailSettings->where('type', 'smtp')->first()->encryption ?? '') }}">
                                </div>
                            </div>

                            <div id="sendgrid-settings" class="mail-settings">
                                <div class="mb-3">
                                    <label for="api_key" class="form-label">API Key</label>
                                    <input type="text" class="form-control" id="api_key" name="api_key" value="{{ old('api_key', $mailSettings->where('type', 'sendgrid')->first()->api_key ?? '') }}">
                                </div>
                            </div>

                            <div id="useinbox-settings" class="mail-settings" style="display: none;">
                                <div class="mb-3">
                                    <label for="useinbox_api_key" class="form-label">UseInbox API Key</label>
                                    <input type="text" class="form-control" id="useinbox_api_key" name="useinbox_api_key" value="{{ old('useinbox_api_key', $mailSettings->where('type', 'useinbox')->first()->useinbox_api_key ?? '') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="from_address" class="form-label">Gönderen E-posta</label>
                                <input type="email" class="form-control" id="from_address" name="from_address" value="{{ old('from_address', $mailSettings->where('is_active', true)->first()->from_address ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="from_name" class="form-label">Gönderen Adı</label>
                                <input type="text" class="form-control" id="from_name" name="from_name" value="{{ old('from_name', $mailSettings->where('is_active', true)->first()->from_name ?? '') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
            </div>
        </main>



        @include('includes.js.toastr')
    @endsection

    @section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const typeRadios = document.querySelectorAll('input[name="type"]');
                const mailSettings = document.querySelectorAll('.mail-settings');

                function toggleMailSettings() {
                    const selectedType = document.querySelector('input[name="type"]:checked').value;
                    mailSettings.forEach(setting => {
                        setting.style.display = 'none';
                    });
                    document.getElementById(`${selectedType}-settings`).style.display = 'block';
                }

                typeRadios.forEach(radio => {
                    radio.addEventListener('change', toggleMailSettings);
                });

                toggleMailSettings();

                // Şifre görünürlüğünü değiştirme fonksiyonu
                const togglePassword = document.querySelector('#togglePassword');
                const password = document.querySelector('#password');
                const toggleIcon = document.querySelector('#toggleIcon');

                togglePassword.addEventListener('click', function () {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    // İkon değiştirme
                    if (type === 'password') {
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                    } else {
                        toggleIcon.classList.remove('fa-eye');
                        toggleIcon.classList.add('fa-eye-slash');
                    }
                });
            });
        </script>
        <script>
        $(document).ready(function() {
            function toggleSettings() {
                var selectedType = $('#type').val();

                // Tüm ayar alanlarını gizle
                $('.smtp-settings, .sendgrid-settings, .useinbox-settings').hide();

                // Seçilen tipe göre ilgili alanları göster
                if (selectedType === 'smtp') {
                    $('.smtp-settings').show();
                } else if (selectedType === 'sendgrid') {
                    $('.sendgrid-settings').show();
                } else if (selectedType === 'useinbox') {
                    $('.useinbox-settings').show();
                }
            }

            // Sayfa yüklendiğinde ve tip seçimi değiştiğinde ayarları güncelle
            toggleSettings();
            $('#type').change(toggleSettings);
        });
        </script>
    @endsection

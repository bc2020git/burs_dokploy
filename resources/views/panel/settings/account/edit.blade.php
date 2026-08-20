@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Hesap Ayarları
@endsection
@section('local-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
@section('body')
    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
            <div class="d-flex">
            </div>
            <div class="btn-toolbar  mb-md-0">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-outline-primary me-3" id="kaydetVeKapatBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z" fill="#4069E5"/>
                        </svg>
                        Kaydet ve Kapat
                    </button>
                    <button type="button" class="btn btn-outline-primary me-3"  id="kaydetBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M5.83333 15.8333V10.8333H14.1667V15.8333H15.8333V6.52369L13.4763 4.16667H4.16667V15.8333H5.83333ZM3.33333 2.5H14.1667L17.5 5.83333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM7.5 12.5V15.8333H12.5V12.5H7.5Z" fill="#4069E5"/>
                        </svg>
                        Kaydet
                    </button>
                </div>
            </div>
        </div>

        <main class="main-content px-3 py-4">
            <div class="container mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                    <h5 class="card-title mb-4">Hesap Bilgileri</h5>
                        <form id="accountDetailForm" class="p-4">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                                    <label for="name" class="custom-label">Kullanıcı Ad</label>
                                    <input id="name" name="name" type="text" class="form-control" value="{{$user->name}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="surname" class="custom-label">Kullanıcı Soyad</label>
                                    <input id="surname" name="surname" type="text" class="form-control" value="{{$user->surname}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="gorev" class="custom-label">Kullanıcı Görev</label>
                                    <input id="gorev" name="gorev" type="text" class="form-control" value="{{$user->gorev}}">
                                </div>
                                <div class="col-md-6 d-flex flex-column form-group">
                                    <label for="tel_no" class="custom-label">Telefon Numarası</label>
                                    <input id="tel_no" name="tel_no" type="tel" class="form-control" value="{{$user->tel_no}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email" class="custom-label">Kullanıcı Eposta Adresi</label>
                                    <input id="email" name="email" type="email" class="form-control" value="{{$user->email}}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Şifre Değiştirme Alanı -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Şifre Değiştir</h5>
                        <form id="passwordChangeForm" class="p-4">
                            <div class="row">
                                <div class="col-md-4 form-group mb-3 position-relative">
                                    <label for="currentPassword" class="custom-label">Mevcut Şifre</label>
                                    <input id="currentPassword" name="currentPassword" type="password" class="form-control">
                                    <div class="password-toggle-icon position-absolute" style="top: 38px; right: 25px; cursor: pointer;">
                                        <i class="fas fa-eye-slash text-muted" onclick="togglePasswordVisibility('currentPassword', this)"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-3 position-relative">
                                    <label for="newPassword" class="custom-label">Yeni Şifre</label>
                                    <input id="newPassword" name="newPassword" type="password" class="form-control">
                                    <div class="password-toggle-icon position-absolute" style="top: 38px; right: 25px; cursor: pointer;">
                                        <i class="fas fa-eye-slash text-muted" onclick="togglePasswordVisibility('newPassword', this)"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-3 position-relative">
                                    <label for="newPasswordConfirm" class="custom-label">Yeni Şifre Tekrar</label>
                                    <input id="newPasswordConfirm" name="newPasswordConfirm" type="password" class="form-control">
                                    <div class="password-toggle-icon position-absolute" style="top: 38px; right: 25px; cursor: pointer;">
                                        <i class="fas fa-eye-slash text-muted" onclick="togglePasswordVisibility('newPasswordConfirm', this)"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <button style='border-radius: 4px;border: 1px solid var(--blue-300, #0065FF);background: var(--blue-0, #DEEBFF);color: var(--blue-300, #0065FF);display: flex;height: 40px;width: auto;padding: 0px 12px 0px 8px;justify-content: center;align-items: center;gap: 8px;' type="button" class="btn btn-outline-primary me-3"  disabled id="changePasswordBtn">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z" fill="#4069E5"/>
                                        </svg>
                                            Şifreyi Değiştir
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="generatePasswordBtn">
                                    <i class="fas fa-key"></i> Şifre Oluştur
                                </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        @include('includes.js.toastr')
    @endsection

    @section('scripts')
        <!-- App js -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="{{url('')}}/assets/js/components/dashboard.js"></script>
        <script src="{{url('')}}/assets/js/components/scholarmodal.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

        <script>
            $(document).ready(function() {
                // Telefon numarası için intl-tel-input başlatma
                const phoneInputField = document.querySelector("#tel_no");
                const phoneInput = window.intlTelInput(phoneInputField, {
                    initialCountry: "tr",
                    separateDialCode: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
                    formatOnDisplay: true
                });

                // Numara girişi sırasında formatlama
                phoneInputField.addEventListener('keyup', function() {
                    const formattedNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL);
                    phoneInputField.value = formattedNumber.replace(/ /g, " ");
                });

                function submitForm(redirectUrl = null) {
                    // Form verilerini al
                    let formData = {};
                    formData['id'] = $('#id').val();
                    formData['name'] = $('#name').val();
                    formData['surname'] = $('#surname').val();
                    formData['gorev'] = $('#gorev').val();
                    formData['email'] = $('#email').val();
                    formData['tel_no'] = phoneInput.getNumber(); // Tam telefon numarasını al

                    // AJAX isteği
                    $.ajax({
                        url: '{{route('update-account')}}',
                        type: 'POST',
                        data: {
                            formData: formData,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                iziToast.success({
                                    title: 'İşlem Başarılı',
                                    message: 'Hesap Bilgileri Güncellendi',
                                });
                                if (redirectUrl) {
                                    window.location.href = redirectUrl;
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            iziToast.error({
                                title: 'İşlem Başarısız',
                                message: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                            });
                            console.error("AJAX Hatası:", status, error);
                            console.error("Hata Detayları:", xhr.responseText);
                        }
                    });
                }

                // "Kaydet" butonuna tıklanınca
                $('#kaydetBtn').click(function() {
                    submitForm();
                });
                // "Kaydet ve Kapat" butonuna tıklanınca
                $('#kaydetVeKapatBtn').click(function() {
                    submitForm('/panel');
                });

                // Şifre değiştirme işlemi
                $('#changePasswordBtn').click(function() {
                    var currentPassword = $('#currentPassword').val();
                    var newPassword = $('#newPassword').val();
                    var newPasswordConfirm = $('#newPasswordConfirm').val();

                    if (newPassword !== newPasswordConfirm) {
                        iziToast.error({
                            title: 'Hata',
                            message: 'Yeni şifreler eşleşmiyor!',
                        });
                        return;
                    }

                    // AJAX isteği ile şifre değiştirme
                    $.ajax({
                        url: '{{route('change-password')}}',
                        type: 'POST',
                        data: {
                            currentPassword: currentPassword,
                            newPassword: newPassword,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                iziToast.success({
                                    title: 'Başarılı',
                                    message: response.message,
                                });
                                // Şifre alanlarını temizle
                                $('#currentPassword, #newPassword, #newPasswordConfirm').val('');
                                setTimeout(function() {
                                    window.location.href = '{{ route('panel-logout') }}';
                                }, 2000);
                            } else {
                                iziToast.error({
                                    title: 'Hata',
                                    message: response.message,
                                });
                            }
                        },
                        error: function() {
                            iziToast.error({
                                title: 'Hata',
                                message: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                            });
                        }
                    });
                });

                // Şifre gereksinimleri için HTML ekle
                $('#passwordChangeForm').prepend(`
                    <div id="password-requirements" style="display:none">
                        <p class="mb-2">Şifre gereksinimleri:</p>
                        <ul class="list-unstyled">
                            <li id="length-check" class="text-danger">
                                <i class="fas fa-times"></i> En az 8 karakter
                            </li>
                            <li id="number-check" class="text-danger">
                                <i class="fas fa-times"></i> En az 1 rakam
                            </li>
                            <li id="special-check" class="text-danger">
                                <i class="fas fa-times"></i> En az 1 noktalama işareti
                            </li>
                            <li id="match-check" class="text-danger">
                                <i class="fas fa-times"></i> Şifreler eşleşmeli
                            </li>
                        </ul>
                    </div>
                `);

                function checkPasswordStrength() {
                    const password = $('#newPassword').val();
                    const confirmPassword = $('#newPasswordConfirm').val();

                    // Şifre alanı boşsa gereksinimleri gizle
                    if (!password) {
                        $('#password-requirements').hide();
                        enableButtons();
                        return;
                    }

                    $('#password-requirements').show();

                    // Gereksinimleri kontrol et
                    const hasLength = password.length >= 8;
                    const hasNumber = /\d/.test(password);
                    const hasSpecial = /[!@#$%^&*()_+=-]/.test(password);
                    const passwordsMatch = password === confirmPassword;

                    // Görsel geri bildirim
                    updateRequirement('length-check', hasLength);
                    updateRequirement('number-check', hasNumber);
                    updateRequirement('special-check', hasSpecial);
                    updateRequirement('match-check', passwordsMatch);

                    // Butonları kontrol et
                    if ((hasLength && hasNumber && hasSpecial && passwordsMatch) || !password) {
                        enableButtons();
                    } else {
                        disableButtons();
                    }
                }

                function updateRequirement(id, isValid) {
                    const element = $(`#${id}`);
                    if (isValid) {
                        element.removeClass('text-danger').addClass('text-success text-bold text-white');
                        element.find('i').removeClass('fa-times').addClass('fa-check');
                    } else {
                        element.removeClass('text-success text-bold text-white').addClass('text-danger');
                        element.find('i').removeClass('fa-check').addClass('fa-times');
                    }
                }

                function enableButtons() {
                    $('#changePasswordBtn').prop('disabled', false);
                }

                function disableButtons() {
                    $('#changePasswordBtn').prop('disabled', true);
                }

                // Event listeners
                $('#newPassword, #newPasswordConfirm').on('keyup', checkPasswordStrength);

                // Toggle butonları ekle
                $('#passwordChangeForm .row:first').find('.form-group').each(function(index) {
                    const inputId = $(this).find('input').attr('id');
                    $(this).append(`
                        <div class="password-toggle-icon position-absolute" style="top: 38px; right: 25px; cursor: pointer;">
                            <i class="fas fa-eye-slash text-muted" onclick="togglePasswordVisibility('${inputId}', this)"></i>
                        </div>
                    `);
                });

                // Şifre alanlarını gizle/göster
                window.togglePasswordVisibility = function(inputId, icon) {
                    const input = document.getElementById(inputId);
                    if (input.type === 'password') {
                        input.type = 'text';
                        $(icon).removeClass('fa-eye-slash').addClass('fa-eye');
                    } else {
                        input.type = 'password';
                        $(icon).removeClass('fa-eye').addClass('fa-eye-slash');
                    }
                };

                // Şifre oluşturma fonksiyonu
                $('#generatePasswordBtn').click(function() {
                    const length = 12;
                    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+=-";
                    let password = "";

                    // En az bir rakam, bir özel karakter ve 8 karakter uzunluğunda olacak şekilde şifre oluştur
                    let hasNumber = false;
                    let hasSpecial = false;

                    for (let i = 0; i < length; i++) {
                        const randomChar = charset.charAt(Math.floor(Math.random() * charset.length));
                        password += randomChar;

                        if (/\d/.test(randomChar)) hasNumber = true;
                        if (/[!@#$%^&*()_+=-]/.test(randomChar)) hasSpecial = true;
                    }

                    // Eğer gerekli koşullar sağlanmıyorsa tekrar oluştur
                    if (!hasNumber || !hasSpecial || password.length < 8) {
                        $(this).click();
                        return;
                    }

                    $('#newPassword').val(password);
                    $('#newPasswordConfirm').val(password);

                    // Şifre kontrolünü tetikle
                    $('#newPassword, #newPasswordConfirm').trigger('keyup');

                    // Kullanıcıya şifrenin oluşturulduğunu bildir
                    iziToast.success({
                        title: 'Başarılı',
                        message: 'Güçlü bir şifre oluşturuldu',
                    });
                });

            });

            $('#reload').on('click', function() {
                location.reload();
            });
        </script>
        @include('includes.js.sidebar')
    @endsection

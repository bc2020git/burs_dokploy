@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Kullanıcı Yönetimi
@endsection
@section('local-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://datatables-cdn.com/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://datatables-cdn.com/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #198754;
        }

        input:checked + .slider:before {
            transform: translateX(30px);
        }

        .switch-text {
            position: absolute;
            width: 100%;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: black;
            left: 60px;
            line-height: 30px;
            text-transform: uppercase;
            z-index: 1;
        }

        input:checked ~ .switch-text:before {
            content: "Aktif";
            padding-right: 5px;
        }

        input:not(:checked) ~ .switch-text:before {
            content: "Pasif";
            padding-left: 5px;
        }
    </style>
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div class="navbar-button-container   mb-3">
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn me-3 text-white" id="newAdd" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Yeni Kullanıcı Ekle" onclick="openUserModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="white" />
                            </svg>
                            Yeni Kullanıcı
                        </button>
                    </div>
                    <div class="d-flex flex-wrap justify-content-start mb-2">
                        <button type="button" class="btn btn-outline-primary" id="reload" data-bs-toggle="tooltip" data-bs-placement="left" title="Yenile">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 30 30">
                                <path d="M 15 3 C 12.031398 3 9.3028202 4.0834384 7.2070312 5.875 A 1.0001 1.0001 0 1 0 8.5058594 7.3945312 C 10.25407 5.9000929 12.516602 5 15 5 C 20.19656 5 24.450989 8.9379267 24.951172 14 L 22 14 L 26 20 L 30 14 L 26.949219 14 C 26.437925 7.8516588 21.277839 3 15 3 z M 4 10 L 0 16 L 3.0507812 16 C 3.562075 22.148341 8.7221607 27 15 27 C 17.968602 27 20.69718 25.916562 22.792969 24.125 A 1.0001 1.0001 0 1 0 21.494141 22.605469 C 19.74593 24.099907 17.483398 25 15 25 C 9.80344 25 5.5490109 21.062074 5.0488281 16 L 8 16 L 4 10 z" fill="#4069E5"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table id="userTable" class="table table-hover w-100">
                        @include('panel.includes.datatable-head-guncel')
                        <tbody id="userTableBody">
                            <!--@foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->tel_no }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->gorev }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <label class="switch">
                                                <input type="checkbox" class="status-switch" data-id="{{ $user->id }}" {{ $user->status == 'Aktif' ? 'checked' : '' }} onchange="changeStatus(this)">
                                                <span class="slider"></span>
                                                <span class="switch-text"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" onclick="openUserModal({{ json_encode($user) }})">Düzenle</button>
                                        <button class="btn btn-danger" onclick="deleteUser({{ $user->id }})">Sil</button>
                                    </td>
                                </tr>
                            @endforeach -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Kullanıcı Ekle/Düzenle Modalı -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Kullanıcı Ekle/Düzenle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="width: 100%;">
                        <form id="userForm">
                            <input type="hidden" id="userId" name="userId">
                            <div class="mb-3">
                                <label for="name" class="form-label">Ad</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="surname" class="form-label">Soyad</label>
                                <input type="text" class="form-control" id="surname" name="surname" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="tel_no" class="form-label">Telefon</label>
                                <input type="tel" class="form-control" id="tel_no" name="tel_no">
                            </div>
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Rol</label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Rol Seçin</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="gorev" class="form-label">Görev</label>
                                <input type="text" class="form-control" id="gorev" name="gorev" required>
                            </div>
                            <div class="mb-3">
                                <label for="accepted_ip" class="form-label">Kabul Edilen IP Adresi <small class="text-muted">(Boş bırakılırsa tüm IP'ler kabul edilir)</small></label>
                                <input type="text" class="form-control" id="accepted_ip" name="accepted_ip" placeholder="Örn: 192.168.1.1">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre <span id="passwordHint" class="text-danger" style="display: none;">(Şifrenin değişmemesi için boş bırakınız)</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" minlength="8">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Şifre Tekrar <span id="passwordConfirmationHint" class="text-danger" style="display: none;">(Şifrenin değişmemesi için boş bırakınız)</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="createPasswordButton">Şifre Oluştur</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="button" class="btn btn-primary" id="saveUserButton">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>

        @include('includes.js.toastr')
        @include('includes.js.sidebar')

    @endsection

    @section('scripts')

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://datatables-cdn.com/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        @include('panel.settings.users.scriptf')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
        <script>
            // Status switch olayını dinle
function changeStatus(element) {
    const userId = $(element).data('id');
    const newStatus = $(element).prop('checked') ? 'Aktif' : 'Pasif';
    const $switch = $(element); // Switch elementini sakla

    $.ajax({
        url: `/panel/settings/users/${userId}/change-status`,
        type: 'POST',
        data: {
            status: newStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
                // Başarısız olursa switch'i eski haline getir
                $switch.prop('checked', !$switch.prop('checked'));
            }
        },
        error: function() {
            toastr.error('İşlem sırasında bir hata oluştu');
            // Hata durumunda switch'i eski haline getir
            $switch.prop('checked', !$switch.prop('checked'));
        }
    });
}

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
            function openUserModal(userId = null) {
                if (userId) {
                    // Kullanıcı bilgilerini AJAX ile çek
                    $.ajax({
                        url: `/panel/settings/users/${userId}/edit`,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                const user = response.user;

                                // Düzenleme işlemi
                                $('#userModalLabel').text('Kullanıcı Düzenle');
                                $('#userId').val(user.id);
                                $('#name').val(user.name);
                                $('#surname').val(user.surname);
                                $('#email').val(user.email);
                                $('#tel_no').val(user.tel_no);
                                $('#role_id').val(user.role_id);
                                $('#gorev').val(user.gorev);
                                $('#accepted_ip').val(user.accepted_ip);

                                // Şifre alanlarını boşalt ve uyarı metnini göster
                                $('#password').val('');
                                $('#password_confirmation').val('');
                                $('#passwordHint').show();
                                $('#passwordConfirmationHint').show();

                                // Modalı göster
                                $('#userModal').modal('show');
                            } else {
                                toastr.error('Kullanıcı bilgileri alınamadı');
                            }
                        },
                        error: function() {
                            toastr.error('Kullanıcı bilgileri alınırken bir hata oluştu');
                        }
                    });
                } else {
                    // Ekleme işlemi
                    $('#userModalLabel').text('Kullanıcı Ekle');
                    $('#userForm')[0].reset();
                    $('#userId').val('');
                    $('#passwordHint').hide();
                    $('#passwordConfirmationHint').hide();
                    $('#userModal').modal('show');
                }
            }

            function generateRandomPassword(length = 8) {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
                let password = "";
                for (let i = 0; i < length; i++) {
                    password += charset.charAt(Math.floor(Math.random() * charset.length));
                }
                return password;
            }

            function togglePasswordVisibility(inputId, buttonId) {
                const input = document.getElementById(inputId);
                const button = document.getElementById(buttonId);
                if (input.type === "password") {
                    input.type = "text";
                    button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    input.type = "password";
                    button.innerHTML = '<i class="fas fa-eye"></i>';
                }
            }

            $(document).ready(function() {
                $('#saveUserButton').on('click', function() {
                    const userId = $('#userId').val();
                    const url = userId ? '{{ route('users.update', '') }}/' + userId : '{{ route('users.store') }}';
                    const method = userId ? 'PUT' : 'POST';

                    $.ajax({
                        url: url,
                        method: method,
                        data: $('#userForm').serialize(),
                        success: function(response) {
                            $('#userModal').modal('hide');
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                });

                $('#createPasswordButton').on('click', function() {
                    const password = generateRandomPassword();
                    $('#password').val(password);
                    $('#password_confirmation').val(password);
                    toastr.success('8 karakterli rastgele şifre oluşturuldu.');
                });

                $('#togglePassword').on('click', function() {
                    togglePasswordVisibility('password', 'togglePassword');
                });

                $('#togglePasswordConfirmation').on('click', function() {
                    togglePasswordVisibility('password_confirmation', 'togglePasswordConfirmation');
                });


            });

            function loadUsers() {
                $.ajax({
                    url: '{{ route('users.index') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#userTableBody').empty();
                        data.forEach(user => {
                            $('#userTableBody').append(`
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.surname}</td>
                                    <td>${user.email}</td>
                                    <td>${user.tel_no}</td>
                                    <td>${user.role ? user.role.name : ''}</td>
                                    <td>${user.gorev}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <label class="switch">
                                                <input type="checkbox" class="status-switch" data-id="${user.id}" ${user.status === 'Aktif' ? 'checked' : ''} onchange="changeStatus(this)">
                                                <span class="slider"></span>
                                                <span class="switch-text"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="openUserModal(${user.id})">
                                            <i class="fas fa-edit"></i> Düzenle
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">
                                            <i class="fas fa-trash"></i> Sil
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
                    },
                    error: function(xhr) {
                        console.error("Hata:", xhr);
                        toastr.error('Kullanıcı verileri yüklenirken bir hata oluştu.');
                    }
                });
            }

            function deleteUser(userId) {
                if (confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')) {
                    $.ajax({
                        url: '{{ route('users.destroy', '') }}/' + userId,
                        method: 'DELETE',
                        success: function(response) {

                            toastr.success(response.message);
                            location.reload();

                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            }
        </script>
    @endsection

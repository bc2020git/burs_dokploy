@extends('layouts.student.master')
@section('title')
    Şifre Değiştir
@endsection
@section('page-title')
    Şifre Değiştir
@endsection
@section('local-css')
<style>
#changePasswordBtn{

    border-radius: 4px;
    border: 1px solid var(--blue-300, #0065FF);
    background: var(--blue-0, #DEEBFF);
    color: var(--blue-300, #0065FF);
    display: flex;
    height: 40px;
  width: auto;
  padding: 0px 12px 0px 8px;
  justify-content: center;
  align-items: center;
  gap: 8px;
}
  </style>
  @endsection
@section('body')

@endsection
@section('content')
    <main class="main-content px-3 py-4">
        <div class="mb-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

        </div>

        <div class=" card shadow-sm mt-4">
            <div class="card-body">
                <h4 class="card-title">Şifre Değiştir</h4>

                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('student.changePassword') }}" method="POST" id="changePasswordForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::guard('bursiyer')->user() ? Auth::guard('bursiyer')->user()->id : Auth::guard('aday')->user()->id }}">
                            <input type="hidden" name="type" value="{{ session()->get('type') }}">

                            <div class="mb-3">
                                <label for="new_password" class="form-label">Yeni Şifre</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Yeni Şifre Tekrar</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                    <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="changePasswordBtn">
                                    <i class="fas fa-save me-1"></i> Şifreyi Değiştir
                                </button>
                                <button type="button" class="btn btn-secondary" id="generatePasswordBtn">
                                    <i class="fas fa-key me-1"></i> Şifre Oluştur
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <!-- App js -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script src="{{url('')}}/assets/js/components/dashboard-student.js"></script>
    <script src="{{url('')}}/assets/js/components/modal.js"></script>
    @include('includes.js.sidebar')

    <script>
        $(document).ready(function() {
            // Rastgele şifre oluşturma fonksiyonu
            function generateRandomPassword(length = 8) {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
                let password = "";
                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * charset.length);
                    password += charset[randomIndex];
                }
                return password;
            }

            // Şifre oluştur butonuna tıklandığında
            $("#generatePasswordBtn").click(function() {
                const randomPassword = generateRandomPassword(8);
                $("#new_password").val(randomPassword);
                $("#new_password_confirmation").val(randomPassword);

                // Kullanıcıya şifrenin oluşturulduğuna dair bilgi verelim
            });

            // Şifre görünürlüğünü toggle etme
            $("#toggleNewPassword").click(function() {
                const passwordField = $("#new_password");
                const type = passwordField.attr("type") === "password" ? "text" : "password";
                passwordField.attr("type", type);
                $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            });

            $("#toggleConfirmPassword").click(function() {
                const confirmPasswordField = $("#new_password_confirmation");
                const type = confirmPasswordField.attr("type") === "password" ? "text" : "password";
                confirmPasswordField.attr("type", type);
                $(this).find("i").toggleClass("fa-eye fa-eye-slash");
            });
        });
    </script>
@endsection

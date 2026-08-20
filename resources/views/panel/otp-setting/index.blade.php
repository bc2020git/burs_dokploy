@extends('layouts.master')
@section('title')
    OTP AYARLARI
@endsection
@section('page-title')
    OTP AYARLARI
@endsection
@section('content')
    <div class="container-fluid otp-setting-page">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">OTP Yapılandırması</h4>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('otp-setting.update') }}" method="POST" class="border p-3 rounded">
                            @csrf
                            <div class="accordion" id="otpSettingsAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingGeneral">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
                                            Genel
                                        </button>
                                    </h2>
                                    <div id="collapseGeneral" class="accordion-collapse collapse show" aria-labelledby="headingGeneral" data-bs-parent="#otpSettingsAccordion">
                                        <div class="accordion-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-0 fw-semibold">OTP ile giriş</p>
                                                    <small class="text-muted">Aday/Bursiyer girişlerinden sonra OTP kodu iste.</small>
                                                </div>
                                                <div class="form-check form-switch m-0">
                                                    <input type="checkbox" class="form-check-input" id="otp_status" name="otp_status" value="1" {{ $settings->otp_status ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="mt-3 p-3 border rounded bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="mb-0 fw-semibold">Portal OTP</p>
                                                        <small class="text-muted">Portal tarafındaki OTP kontrolünü aç/kapat.</small>
                                                    </div>
                                                    <div class="form-check form-switch m-0">
                                                        <input type="checkbox" class="form-check-input otp-dependent" id="portal_otp_status" name="portal_otp_status" value="1" {{ $settings->portal_otp_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div>
                                                        <p class="mb-0 fw-semibold">CRM OTP</p>
                                                        <small class="text-muted">CRM tarafındaki OTP kontrolünü aç/kapat.</small>
                                                    </div>
                                                    <div class="form-check form-switch m-0">
                                                        <input type="checkbox" class="form-check-input otp-dependent" id="crm_otp_status" name="crm_otp_status" value="1" {{ $settings->crm_otp_status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingAdmin">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
                                            Yönetici
                                        </button>
                                    </h2>
                                    <div id="collapseAdmin" class="accordion-collapse collapse" aria-labelledby="headingAdmin" data-bs-parent="#otpSettingsAccordion">
                                        <div class="accordion-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="mb-0 fw-semibold">Yönetici girişinde OTP</p>
                                                    <small class="text-muted">Yönetici girişinde e-posta ile OTP kodu doğrulaması ister.</small>
                                                </div>
                                                <div class="form-check form-switch m-0">
                                                    <input type="checkbox" class="form-check-input" id="admin_otp_status" name="admin_otp_status" value="1" {{ $settings->admin_otp_status ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr class="my-4">

                            <button type="button" class="btn cancel-button" id="prevStep" onclick="location.href='{{route('panel')}}'">Vazgeç</button>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
    /* Page-scoped toggle switch (prevents theme conflicts) */
    .otp-setting-page .form-switch {
        padding-left: 0;
        min-height: auto;
    }

    .otp-setting-page .form-switch .form-check-input {
        --track-w: 46px;
        --track-h: 26px;
        --knob: 20px;
        --gap: 3px;

        width: var(--track-w) !important;
        height: var(--track-h) !important;
        margin: 0 !important;
        padding: 0 !important;
        display: inline-block;
        vertical-align: middle;

        cursor: pointer;
        border-radius: 999px !important;
        border: 1px solid rgba(0, 0, 0, .10) !important;

        background-color: #e9ecef !important;
        background-image: none !important;
        background-position: initial !important;
        background-repeat: no-repeat !important;
        box-shadow: none !important;
        outline: none !important;

        position: relative;
        overflow: hidden;
        box-sizing: border-box;
        appearance: none;
        -webkit-appearance: none;
        transition: background-color .15s ease, border-color .15s ease;
    }

    .otp-setting-page .form-switch .form-check-input::after {
        content: '';
        position: absolute;
        top: var(--gap);
        left: var(--gap);
        width: var(--knob);
        height: var(--knob);
        border-radius: 999px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .18);
        transform: translateX(0);
        transition: transform .15s ease;
    }

    .otp-setting-page .form-switch .form-check-input:checked {
        background-color: #0d6efd !important;
        border-color: rgba(13, 110, 253, .45) !important;
    }

    .otp-setting-page .form-switch .form-check-input:checked::after {
        transform: translateX(calc(var(--track-w) - var(--knob) - (var(--gap) * 2)));
    }

    .otp-setting-page .form-switch .form-check-input:focus {
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .18) !important;
    }

    .otp-setting-page .form-switch .form-check-input:disabled {
        cursor: not-allowed;
        opacity: .55;
    }
</style>
<script>
$(document).ready(function() {
    // Mevcut ayarları form elemanlarına yansıt
    @if(isset($settings))
        $('#otp_status').prop('checked', {{ $settings->otp_status ? 'true' : 'false' }});
        $('#crm_otp_status').prop('checked', {{ $settings->crm_otp_status ? 'true' : 'false' }});
        $('#portal_otp_status').prop('checked', {{ $settings->portal_otp_status ? 'true' : 'false' }});
        $('#admin_otp_status').prop('checked', {{ $settings->admin_otp_status ? 'true' : 'false' }});
    @endif

    // Switch değişikliklerini dinle ve kaydet
    $('.form-check-input').on('change', function() {
        updateOtpDependentInputs();

        const formData = {
            _token: '{{ csrf_token() }}',
            otp_status: $('#otp_status').is(':checked'),
            crm_otp_status: $('#crm_otp_status').is(':checked'),
            portal_otp_status: $('#portal_otp_status').is(':checked'),
            admin_otp_status: $('#admin_otp_status').is(':checked')
        };

        $.ajax({
            url: '{{ route("otp-setting.update") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');
            }
        });
    });

    function updateOtpDependentInputs() {
        const otpEnabled = $('#otp_status').is(':checked');
        $('.otp-dependent').prop('disabled', !otpEnabled);
    }

    updateOtpDependentInputs();
});
</script>
@endsection

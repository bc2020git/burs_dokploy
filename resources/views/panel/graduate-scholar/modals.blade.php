<!--Modal Alanı-->
<!--Başvuru Dönemi Başlamıştır-->
<!-- Uyarı Modali -->
<div class="modal fade" id="interviewWarningModal" tabindex="-1" aria-labelledby="interviewWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="interviewWarningModalLabel">Uyarı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fw-medium">
                Lütfen en az bir öğrenci seçiniz.
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>
<!-- Öğrenciyi Geri Al Modal -->
<div class="modal fade" id="undoModal" tabindex="-1" aria-labelledby="undoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path
                        d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                        stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M11.3633 11.2497C11.6572 10.4143 12.2372 9.70987 13.0007 9.26115C13.7642 8.81243 14.6619 8.64841 15.5348 8.79813C16.4076 8.94784 17.1993 9.40164 17.7696 10.0791C18.34 10.7566 18.6521 11.6141 18.6508 12.4997C18.6508 14.9997 14.9008 16.2497 14.9008 16.2497"
                        stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15 21.25H15.0125" stroke="#8353E2" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                </svg>
                <h5 class="mt-3">Öğrenciyi geri almak istediğinize emin misiniz?</h5>
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-outline-danger " id="deniedbtn" data-bs-dismiss="modal"> Öğrenciyi Geri Al </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- geri alma başarılı Modal -->
<div class="modal fade" id="deniedbtnModal" tabindex="-1" aria-labelledby="deniedbtnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                    <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white" stroke-width="2" />
                    <path
                        d="M10.533 13.8859C9.77395 13.1615 8.54324 13.1615 7.78415 13.8859C7.02507 14.6104 7.02507 15.785 7.78415 16.5095L11.6717 20.2197C12.4307 20.9441 13.6615 20.9441 14.4205 20.2197L22.1955 12.7992C22.9546 12.0748 22.9546 10.9002 22.1955 10.1757C21.4365 9.45127 20.2057 9.45127 19.4467 10.1757L13.0461 16.2844L10.533 13.8859Z"
                        fill="white" />
                </svg>
                <h5 class="mt-3">Öğrenci başarıyla geri alındı!</h5>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>
<!-- Öğrenciyi Aktif Et Modal -->
<div class="modal fade" id="setAktifModal" tabindex="-1" aria-labelledby="setAktifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path
                        d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                        stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M11.3633 11.2497C11.6572 10.4143 12.2372 9.70987 13.0007 9.26115C13.7642 8.81243 14.6619 8.64841 15.5348 8.79813C16.4076 8.94784 17.1993 9.40164 17.7696 10.0791C18.34 10.7566 18.6521 11.6141 18.6508 12.4997C18.6508 14.9997 14.9008 16.2497 14.9008 16.2497"
                        stroke="#8353E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15 21.25H15.0125" stroke="#8353E2" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                </svg>
                <h5 class="mt-3">Seçilen öğrencileri aktif etmek istediğinize emin misiniz?</h5>
                <p class="text-muted">
                    Öğrenci kayıt yenileme alanına taşınacak ve öğrenim türü bir üst tür ile değiştirilecektir.
                </p>
                <div class="d-flex mt-5 p-2 justify-content-center">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-outline-primary " id="setAktifBtn" data-bs-dismiss="modal"> Öğrenciyi Aktif Et </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Progress Modal (toplu aktar) -->
<div class="modal fade export-modal" id="exportProgressModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="exportProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportProgressModalLabel">Dosya Hazırlanıyor</h5>
            </div>
            <div class="modal-body text-center px-4">
                <p id="exportProgressText" class="mb-0">Lütfen bekleyiniz, veriler parça parça alınıyor...</p>
                <div class="progress mt-3 w-100" style="height: 20px;">
                    <div id="exportProgressBar" class="progress-bar progress-bar-striped progress-bar-animated"
                        role="progressbar" style="width: 0%; max-width: 100%;" aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100">0%</div>
                </div>
                <p id="exportProgressStatus" class="mt-2 small text-muted mb-0">Başlatılıyor...</p>
            </div>
        </div>
    </div>
</div>
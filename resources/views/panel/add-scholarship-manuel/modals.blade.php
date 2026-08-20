<!--Başvuru Dönemi Başlamıştır-->
<!-- Mezun Et Modal -->
<div class="modal fade" id="graduateModal" tabindex="-1" aria-labelledby="graduateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="29" viewBox="0 0 30 29" fill="none">
                    <rect x="1" y="1" width="28" height="27" rx="9" fill="#00875A" />
                    <rect x="1" y="1" width="28" height="27" rx="9" stroke="white" stroke-width="2" />
                    <path
                        d="M10.533 13.1693C9.77395 12.4356 8.54324 12.4356 7.78415 13.1693C7.02507 13.9031 7.02507 15.0928 7.78415 15.8266L11.6717 19.5845C12.4307 20.3183 13.6615 20.3183 14.4205 19.5845L22.1955 12.0687C22.9546 11.3349 22.9546 10.1452 22.1955 9.41142C21.4365 8.67764 20.2057 8.67764 19.4467 9.41142L13.0461 15.5986L10.533 13.1693Z"
                        fill="white" />
                </svg>
                <h5 class="mt-3">Öğrenci mezun edildi</h5>
                <p>Aday e-posta ve mesaj yolu ile bilgilendirilecek</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<!-- Mezun Et Onay Modalı -->
<div class="modal fade" id="graduateConfirmModal" tabindex="-1" aria-labelledby="graduateConfirmModalLabel" aria-hidden="true">
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
                <h5 class="mt-3">Bursiyer mezun edilecek ve mezunlar alanına taşınacaktır!</h5>
                <p>Onaylıyor musunuz?</p>
                <div class=" d-flex">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn me-3 text-white" id="graduatebtn" data-bs-dismiss="modal"> <svg
                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <path
                                d="M10 1.66675L0 7.50008L10 13.3334L18.3333 8.47233V14.5834H20V7.50008L10 1.66675ZM3.33252 11.2422V15.0002C4.85287 17.0242 7.27343 18.3335 9.99983 18.3335C12.7262 18.3335 15.1467 17.0242 16.6671 15.0002L16.6667 11.2428L10.0003 15.1317L3.33252 11.2422Z"
                                fill="white" />
                        </svg>Mezun Et
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Uyari Modalı -->

<div class="modal fade" id="interviewWarningModal" tabindex="-1" aria-labelledby="interviewWarningModalLabel"
     aria-hidden="true">
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
<!-- Burs İptal Modal -->
<div class="modal fade" id="cancelScholarshipModal" tabindex="-1" aria-labelledby="cancelScholarshipModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                     class="bi bi-x-circle-fill" viewBox="0 0 16 16" style="color: #dc3545;">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.646 4.646a.5.5 0 0 0 0 .708L7.293 8 4.646 10.646a.5.5 0 1 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646a.5.5 0 0 0-.708 0z" />
                </svg>
                <h5 class="mt-3">Burs İptal Edilsin mi?</h5>
                <p>Burs iptal işlemi geri alınamaz. Bu işlemi onaylıyor musunuz?</p>
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal"> Vazgeç</button>
                    <button type="button" class="btn btn-outline-danger" id="cancelbtn" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                             fill="none">
                            <path
                                d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                fill="#A82200" />
                        </svg>
                        Burs İptal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KY Eksik Belge Bildirimi Modalı -->
<div class="modal fade" id="kyMissingDocumentModal" tabindex="-1" aria-labelledby="kyMissingDocumentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path
                        d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM13.75 18.75V21.25H16.25V18.75H13.75ZM13.75 8.75V16.25H16.25V8.75H13.75Z"
                        fill="#636363" />
                </svg>
                <h5 class="mt-3">KY başvurusu iade edilecektir.</h5>
                <p>Onaylıyor musunuz?</p>
                <div class="col-md-12 mb-3">
                    <label for="iadeSebebi" class="form-label">İade Sebebi</label>
                    <select id="iadeSebebi" name="iadeSebebi" class="form-select">
                        <option disabled>İade sebebini seçiniz</option>
                        @foreach($sebepler as $sebep)
                        @if($sebep->type == 'İade')
                            <option value="{{ $sebep->text }}">{{ $sebep->text }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <p>Diğer ise kısaca açıklayınız.</p>
                <textarea id="iadeDigerAciklama" name="iadeDigerAciklama" class="form-control" rows="3" placeholder="Açıklama giriniz..."></textarea>
                <small class="form-text text-muted mt-2">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu
                    ile bilgilendirilecektir!</small>
                <div class="d-flex">
                    <button type="button" class="btn btn-outline-secondary me-3"
                            data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn me-3" id="toReturnbtn" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                             fill="none">
                            <path
                                d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.4888 14.1666L13.9652 12.6429L15.1437 11.4644L18.6792 14.9999L15.1437 18.5354L13.9652 17.3569L15.4888 15.8333H12.5007V14.1666H15.4888Z"
                                fill="#1A1A1A" />
                        </svg>
                        KY İade
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- KY Reddet Modalı -->
<div class="modal fade" id="kyRejectModal" tabindex="-1" aria-labelledby="kyRejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path
                        d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                        stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                    <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" />
                </svg>
                <h5 class="mt-3">KY başvurusu reddedilecektir.</h5>
                <p>Onaylıyor musunuz?</p>
                <p>Red sebebini açıklayınız.</p>
                <div class="col-md-12 mb-3">
                    <label for="redSebebi" class="form-label">Red Sebebi</label>
                    <select id="redSebebi" class="form-select">
                        <option disabled>Red sebebini seçiniz</option>
                        @foreach($sebepler as $sebep)
                        @if($sebep->type == 'Red')
                            <option value="{{ $sebep->text }}">{{ $sebep->text }}</option>
                        @endif
                        @endforeach

                    </select>
                </div>
                <p>Diğer ise kısaca açıklayınız.</p>
                <textarea id="digeraciklama" name="digeraciklama" class="form-control" rows="3" placeholder="Açıklama giriniz..."></textarea>
                <small class="form-text text-muted mt-2">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu
                    ile bilgilendirilecektir!</small>
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn me-3" id="kyDeniedbtn" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z" fill="#A82200"></path>
                        </svg>
                        KY Reddet
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Red İşlemi Başarılı Modalı -->
<div class="modal fade" id="rejectSuccessModal" tabindex="-1" aria-labelledby="rejectSuccessModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path
                        d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                        stroke="#28a745" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M12 17.25L9 14.25L10.2 13L12 14.8L17.8 9L19 10.25L12 17.25Z"
                        fill="#28a745" />
                </svg>
                <h5 class="mt-3">Açıklamanız başarıyla kaydedildi!</h5>
                <p>Öğrenci mesaj ve e-posta yolu ile bilgilendirildi.</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<!-- Başvuru Onayla Modalı -->
<div class="modal fade" id="kySuccessModal" tabindex="-1" aria-labelledby="kySuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <!-- SVG ve Metinler -->
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" fill="#00875A" />
                    <rect x="1" y="1.88379" width="28" height="26.6318" rx="9" stroke="white" stroke-width="2" />
                    <path
                        d="M10.533 13.8859C9.77395 13.1615 8.54324 13.1615 7.78415 13.8859C7.02507 14.6104 7.02507 15.785 7.78415 16.5095L11.6717 20.2197C12.4307 20.9441 13.6615 20.9441 14.4205 20.2197L22.1955 12.7992C22.9546 12.0748 22.9546 10.9002 22.1955 10.1757C21.4365 9.45127 20.2057 9.45127 19.4467 10.1757L13.0461 16.2844L10.533 13.8859Z"
                        fill="white" />
                </svg>
                <h5 class="mt-3">Kayıt yenileme onaylanacak ve öğrenci bursiyerler alanına taşınacaktır.</h5>
                <p>Onaylıyor musunuz?</p>
                <p>Aday mesaj ve e-posta yolu ile bilgilendirilecektir.</p>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-sm me-3" id="kyConfirmbtn" data-bs-dismiss="modal">
                    <!-- Onay SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path
                            d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                            fill="#006644" />
                    </svg>
                    Kayıt Yenileme Onayla
                </button>
            </div>
        </div>
    </div>
</div>
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

<!-- Export Progress Modal -->
<div class="modal fade" id="exportProgressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportProgressModalLabel">Dosya Hazırlanıyor</h5>
            </div>
            <div class="modal-body text-center px-4">
                <p id="exportProgressText">Lütfen bekleyiniz, veriler parça parça alınıyor...</p>
                <div class="px-3">
                    <div class="progress mt-3" style="height: 20px;">
                        <div id="exportProgressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
                <p id="exportProgressStatus" class="mt-2 small text-muted">Başlatılıyor...</p>
            </div>
        </div>
    </div>
</div>


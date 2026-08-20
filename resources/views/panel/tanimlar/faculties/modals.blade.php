<!--Modal Alanı-->
<!-- Burs veriliyor mu Modal -->
<div class="modal fade" id="bursModal" tabindex="-1" aria-labelledby="bursModalLabel" aria-hidden="true">
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
                <div class="col-md-12">
                    <label for="bursVeriliyorMuDurum" class="custom-label">Bu Fakülte/Fakültelere Burs Veriliyor
                        Mu?</label>
                    <select class="form-control" name="bursVeriliyorMuDurum" id="bursVeriliyorMuDurum">
                        <option disabled value="seçenekler">Burs verilme durumunu seçiniz</option>
                        <option value="1" id="confirmYes">Evet</option>
                        <option value="0" id="confirmNo">Hayır</option>
                    </select>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="schooltype" value="onlisans" id="onlisans">
                                <label class="form-check-label" for="onLisans">Ön Lisans</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="schooltype" value="lisans" id="lisans">
                                <label class="form-check-label" for="lisans">Lisans</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="schooltype" value="yukseklisans" id="yukseklisans">
                                <label class="form-check-label" for="yuksekLisans">Yüksek Lisans</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="schooltype" value="doktora" id="doktora">
                                <label class="form-check-label" for="doktora">Doktora</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-outline-success me-3" id="confirmBursDurum" data-bs-dismiss="modal">Tümüne
                    Uygula</button>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Vazgeç</button>
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
                Lütfen en az bir satır seçiniz.
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>

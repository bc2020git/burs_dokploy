<!--Mülakat Oluştur-->
<!--Mülakat Oluştur-->
<div class="modal fade" id="createInterviewModal" tabindex="-1" aria-labelledby="createInterviewModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createInterviewModalLabel">Mülakat Oluştur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="title">Mülakat bilgilerini giriniz</p>
                <p class="small">Oluştur butonuna bastığınızda aday otomatik olarak bilgilendirilecektir</p>
                <form method='post' action='{{route('listnewinterview')}}'  id="createInterviewForm"> @csrf
                    <input type='hidden' id='mulakatadayid' name='mulakatadayid'>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="interviewDate">Mülakat Tarihi</label>
                            <input name="date" type="date" class="form-control inputDate" onfocus="typeChange(this,'text','date')" id="interviewDate" placeholder="Tarih seçiniz">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="interviewTime">Mülakat Saati</label>
                            <input name="time" type="time" class="form-control" id="interviewTime">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="interviewType">Mülakat Tipi</label>
                            <select name="type" class="form-select" id="interviewType">
                                <option selected>Seçiniz</option>
                                <option value="Çevrim içi">Çevrim içi</option>
                                <option value="Yüz Yüze">Yüz Yüze</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="interviewer">Mülakatı Yapacak Kişi</label>
                            <input name="person" type="text" class="form-control" id="interviewer" placeholder="Yazınız..">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="meetingLink">Toplantı Linki / Adresi</label>
                            <input name="address" type="text" class="form-control" id="meetingLink" placeholder="Yazınız..">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="interviewDescription">Mülakat Açıklaması</label>
                            <textarea name="detail" class="form-control" id="interviewDescription" rows="3" placeholder="Yazınız.."></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center" data-bs-dismiss="modal">
                        <button type="submit" class="btn me-3" id="createInterviewCreateButton">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M15 15.8333H15.8333V5.69036L14.3097 4.16667H13.3333V7.5H5.83333V4.16667H4.16667V15.8333H5V10H15V15.8333ZM3.33333 2.5H15L17.2559 4.75592C17.4122 4.9122 17.5 5.12417 17.5 5.34517V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5ZM6.66667 11.6667V15.8333H13.3333V11.6667H6.66667Z" fill="#4069E5" />
                            </svg>
                            Mülakat Oluştur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>        <!-- mülakat başarılı Modal -->
<div class="modal fade" id="saveInterviewModal" tabindex="-1" aria-labelledby="saveInterviewModalLabel" aria-hidden="true">
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
                <h5 class="mt-3">Mülakat başarıyla oluşturuldu!</h5>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
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
<!-- Uyarı Modali -->
<div class="modal fade" id="interviewWarningModal2" tabindex="-1" aria-labelledby="interviewWarningModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="interviewWarningModalLabel2">Uyarı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fw-medium">
                Mülakat için birden fazla öğrenci seçemezsiniz.
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>
<!-- Çoklu Uyarı Modali -->
<div class="modal fade" id="multipleSelectionModal" tabindex="-1" aria-labelledby="multipleSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="multipleSelectionModalLabel">Uyarı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fw-medium">
                Birden fazla öğrenci için mülakat oluşturulamaz.
                Lütfen sadece 1 tane öğrenci seçin.
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
            </div>
        </div>
    </div>
</div>
<!-- Eksik Belge Bildirimi Modalı -->
<div class="modal fade" id="missingDocumentModal" tabindex="-1" aria-labelledby="missingDocumentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM13.75 18.75V21.25H16.25V18.75H13.75ZM13.75 8.75V16.25H16.25V8.75H13.75Z" fill="#636363"/>
                </svg>
                <h5 class="mt-3">Burs başvurusu iade edilecektir.</h5>
                <p>Onaylıyor musunuz?</p>
                <div class="col-md-12 mb-3">
                    <label for="ıadeSebebi" class="form-label">İade Sebebi</label>
                    <select id="ıadeSebebi" class="form-select">
                        <option disabled>İade sebebini seçiniz</option>
                        <option value="1">Belge eksik</option>
                        <option value="2">Belge yanlış</option>
                        <option value="3">Bilgiler yanlış</option>
                        <option value="4">Diğer</option>
                    </select>
                </div>
                <p>Diğer ise kısaca açıklayınız.</p>
                <textarea class="form-control" rows="3" placeholder="Açıklama giriniz..."></textarea>
                <small class="form-text text-muted mt-2">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu
                    ile bilgilendirilecektir!</small>
                <div class="d-flex">
                    <button type="button" class="btn btn-outline-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-outline-dark" id="toReturnbtn" data-bs-dismiss="modal" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.4888 14.1666L13.9652 12.6429L15.1437 11.4644L18.6792 14.9999L15.1437 18.5354L13.9652 17.3569L15.4888 15.8333H12.5007V14.1666H15.4888Z"
                                fill="#1A1A1A" />
                        </svg>
                        Başvuru İade
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Başvuru Reddet Modalı -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
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
                <h5 class="mt-3">Burs başvurusu reddedilecektir.</h5>
                <p>Onaylıyor musunuz?</p>
                <p>Red sebebini açıklayınız.</p>
                <div class="col-md-12 mb-3">
                    <label for="redSebebi" class="form-label">Red Sebebi</label>
                    <select id="redSebebi" class="form-select">
                        <option disabled>Red sebebini seçiniz</option>
                        <option value="Başarısızlık">Başarısızlık</option>
                        <option value="Belge Eksikliği">Belge Eksikliği</option>
                        <option value="Mezun">Mezun</option>
                        <option value="Ekonomik olarak uygun olmamız">Ekonomik olarak uygun olmamız</option>
                        <option value="Başka kurumdan burs alacağınız için">Başka kurumdan burs alacağınız için</option>
                        <option value="Dernek burs yönetmeliğine uygun olmadığınız için">Dernek burs yönetmeliğine uygun olmadığınız için</option>
                        <option value="Burstan vazgeçtiğiniz için">Burstan vazgeçtiğiniz için</option>
                        <option value="Okulu bıraktığınız için">Okulu bıraktığınız için</option>
                        <option value="Nakil gittiğniz il/ilçede derneğimiz olmadığı için">Nakil gittiğniz il/ilçede derneğimiz olmadığı için</option>
                    </select>
                </div>
                <p>Diğer ise kısaca açıklayınız.</p>
                <textarea id="digeraciklama" class="form-control" rows="3" placeholder="Açıklama giriniz..."></textarea>
                <small class="form-text text-muted mt-2">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu
                    ile bilgilendirilecektir!</small>
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-outline-danger" id="btndenied" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                fill="#A82200" />
                        </svg>
                        Burs Ret
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Başvuru Onayla Modalı -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
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
                <h5 class="mt-3">Burs onalayanacak ve öğrenci bursiyerler alanına taşınacaktır.</h5>
                <span>Onaylıyor musunuz?</span>
                <p>Aday mesaj ve e-posta yolu ile bilgilendirilecektir.</p>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-primary" id="confirmbtnmodel" data-bs-dismiss="modal">Burs Onayla</button>
            </div>
        </div>
    </div>
</div>

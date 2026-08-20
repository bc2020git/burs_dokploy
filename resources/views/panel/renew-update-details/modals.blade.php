
<!-- Belge Gosterme Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentModalLabel">Belge Görüntüleyici</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <object id="documentViewer" data="" type="application/pdf" style="width: 100%; height: 500px;">
                    PDF dosyanız burada görüntülenemiyor. Lütfen <a id="pdfDownloadLink" href="#" download>indirerek</a> açın.
                </object>
            </div>
        </div>
    </div>
</div>

<!-- Not Ekleme Modalı -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Yeni Not Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style='width: 100%' >
                <form id="addNoteForm">
                    <div class="mb-3">
                        <label for="noteTitle" class="form-label">Başlık</label>
                        <input type="text" class="form-control" id="noteTitle" placeholder="Başlık yazınız">
                    </div>
                    <div class="mb-3">
                        <label for="noteContent" class="form-label">İçerik</label>
                        <textarea class="form-control" id="noteContent" rows="3" placeholder="İçerik yazınız"></textarea>
                    </div>
                    <input type="hidden" id="noteTcNo" name="tc_no">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" id="saveNoteBtn">Kaydet</button>
            </div>
        </div>
    </div>
</div>
<!-- Kardeş Ekle Modal -->
<div class="modal fade" id="kardesEkleModal" tabindex="-1" aria-labelledby="kardesEkleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="modal-title mb-3" id="kardesEkleModalLabel">Kardeş Ekle</h5>
                    <p>Kardeş bilgilerini giriniz.</p>
                    <span>Ekle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
                </div>
                <form action="{{route('addReNewScholarSibling')}}" id="addSiblingForm" method="post"> @csrf
                    <div class="row">
                        <input type="hidden" name="tc_no" id="tc_no" value="{{$aday->scholar->tc_no}}">
                        <div class="col-md-6 mb-3">
                            <label for="kardesAdi" class="form-label">Adı</label>
                            <input name="name" type="text" class="form-control" id="kardesAdi" placeholder="Ad giriniz...">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kardesSoyadi" class="form-label">Soyadı</label>
                            <input name="surname" type="text" class="form-control" id="kardesSoyadi"
                                   placeholder="Soyad giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kardesYasi" class="form-label">Yaşı</label>
                            <input name="age" type="text" class="form-control" id="kardesYasi" placeholder="Yaş giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                            <select name="educ_status" class="form-select" id="kardesOgrenimDurumu" required>
                                <option disabled>Seçiniz...</option>
                                <option>Ortaokul</option>
                                <option >Lise</option>
                                <option>Lisans</option>
                                <option>Yüksek Lisans</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kardesMedeniDurumu" class="form-label">Medeni Durum</label>
                            <select name="maritality" class="form-select" id="kardesMedeniDurumu" required>
                                <option disabled>Seçiniz...</option>
                                <option>Bekar</option>
                                <option >Evli</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                            <input name="job" type="text" class="form-control" id="kardesMeslegi"
                                   placeholder="Meslek giriniz...">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button id="addSiblingBtn"  class="btn btn-primary">Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Kardeş Düzenle Modal -->
<div class="modal fade" id="kardesDuzenleModal" tabindex="-1" aria-labelledby="kardesDuzenleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="text-center">
                <h5 class="modal-title mb-3" id="kardesDuzenleModalLabel">Kardeş Düzenle</h5>
                <p>Kardeş bilgilerini giriniz.</p>
                <span>Güncelle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('editRenewSiblingDetail')}}" id="editSiblingForm"> @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="hidden" name="id" id="editKardesid">
                            <label for="editkardesAdi" class="form-label">Adı</label>
                            <input name="name" type="text" class="form-control" id="editkardesAdi" placeholder="Ad giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editkardesSoyadi" class="form-label">Soyadı</label>
                            <input name="surname" type="text" class="form-control" id="editkardesSoyadi"
                                   placeholder="Soyad giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kardesYasi" class="form-label">Yaşı</label>
                            <input name="age" type="text" class="form-control" id="editkardesYasi" placeholder="Yaş giriniz...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editkardesOgrenimDurumu" class="form-label">Öğrenim Durumu</label>
                            <select name="educ_status" class="form-select" id="editkardesOgrenimDurumu" required>
                                <option disabled>Seçiniz...</option>
                                <option>Ortaokul</option>
                                <option >Lise</option>
                                <option selected>Lisans</option>
                                <option>Yüksek Lisans</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editkardesMedeniDurumu" class="form-label">Medeni Durum</label>
                            <select name="maritality" class="form-select" id="editkardesMedeniDurumu" required>
                                <option disabled>Seçiniz...</option>
                                <option>Bekar</option>
                                <option selected >Evli</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editkardesMeslegi" class="form-label">Mesleği (Çalışıyorsa)</label>
                            <input name="job" type="text" class="form-control" id="editkardesMeslegi"
                                   placeholder="Meslek giriniz...">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Burs Ekle Modal -->
<div class="modal fade" id="bursEkleModal" tabindex="-1" aria-labelledby="bursEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="text-center">
                <h5 class="modal-title mb-3" id="bursEkleModalLabel">Burs Ekle</h5>
                <p>Burs bilgilerini giriniz.</p>
                <span>Ekle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
            </div>
            <div class="modal-body">
                <form action="{{route('addRenewScholarScholarShip')}}" method="post" id="addBursForm">@csrf
                    <input type="hidden" name="tc_no" id="tc_no" value="{{$aday->scholar->tc_no}}">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="kurumAdi" class="form-label">Burs Aldığınız Kurumun Adı</label>
                            <input name='company_name' type="text" class="form-control" id="kurumAdi"
                                   placeholder="Kurum adı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kurumTuru" class="form-label">Kurum Türü</label>
                            <select name='company_type' class="form-select" id="kurumTuru" required>
                                <option selected disabled>Seçiniz...</option>
                                <option value="Devlet">Devlet</option>
                                <option value="Özel">Özel</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                            <input name='count' type="text" class="form-control" id="bursMıktarı" placeholder="Örnek Burs Tutarı: 1000">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary">Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Burs Düzenle Modal -->
<div class="modal fade" id="bursDuzenleModal" tabindex="-1" aria-labelledby="bursDuzenleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="text-center">
                <h5 class="modal-title mb-3" id="bursEkleModalLabel">Burs Düzenle</h5>
                <p>Burs bilgilerini giriniz.</p>
                <span>Güncelle butonuna bastığınızda bilgiler otomatik olarak listelenecektir!</span>
            </div>
            <div class="modal-body">
                <form action="{{route('editRenewScholarScholarShip')}}" method="post" id="editBursForm"> @csrf
                    <div class="row">
                        <input type="hidden" name="id" id="editbursid">
                        <div class="col-md-12 mb-3">
                            <label for="editkurumAdi" class="form-label">Kurum Adı</label>
                            <input name='company_name' type="text" class="form-control" id="editkurumAdi" placeholder="Kurum adı giriniz...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editkurumTuru" class="form-label">Kurum Türü</label>
                            <select name='company_type' class="form-select" id="editkurumTuru" required>
                                <option disabled>Seçiniz...</option>
                                <option value="Devlet">Devlet</option>
                                <option value="Özel">Özel</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editbursMıktarı" class="form-label">Burs Tutarı (TL)</label>
                            <input name='count' type="text" class="form-control" id="editbursMıktarı" placeholder="Örnek Burs Tutarı: 1000">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Eksik Belge Bildirimi Modalı -->
<div class="modal fade" id="kyMissingDocumentModal" tabindex="-1" aria-labelledby="kyMissingDocumentModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path
                        d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM13.75 18.75V21.25H16.25V18.75H13.75ZM13.75 8.75V16.25H16.25V8.75H13.75Z"
                        fill="#636363" />
                </svg>
                <h5 class="mt-3">Kayıt Yenileme başvurusu iade edilecektir.</h5>
                <p>Onaylıyor musunuz?</p>
                <div class="col-md-12 mb-3">
                    <label for="iadeSebebi" class="form-label">İade Sebebi</label>
                    <select id="iadeSebebi" class="form-select">
                        <option disabled>İade sebebini seçiniz</option>
                        @foreach($sebepler as $sebep)
                        @if($sebep->type == 'İade')
                            <option value="{{ $sebep->text }}">{{ $sebep->text }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <p>Diğer ise kısaca açıklayınız.</p>
                <textarea class="form-control" rows="3" id="iadeAciklamasi" placeholder="Açıklama giriniz..."></textarea>
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
                        Kayıt Yenileme İade
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Başvuru Reddet Modalı -->
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
                <textarea class="form-control" rows="3" id="redAciklamasi" placeholder="Açıklama giriniz..."></textarea>
                <small class="form-text text-muted mt-2">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu
                    ile bilgilendirilecektir!</small>
                <div class="d-flex">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn me-3" id="kyDeniedbtn" data-bs-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                             fill="none">
                            <path
                                d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16659C11.8423 9.16659 13.334 7.67492 13.334 5.83325C13.334 3.99159 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99159 6.66732 5.83325C6.66732 7.67492 8.15898 9.16659 10.0007 9.16659ZM15.834 14.6548L17.6017 12.887L18.7802 14.0655L17.0125 15.8333L18.7802 17.601L17.6017 18.7795L15.834 17.0118L14.0662 18.7795L12.8877 17.601L14.6555 15.8333L12.8877 14.0655L14.0662 12.887L15.834 14.6548Z"
                                fill="#A82200" />
                        </svg>
                        Kayıt Yenileme Reddet
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ön değerlendirme Onayla Modalı -->
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
                <a href="{{route('kayitYenilemeSonuclandir',['id'=>$aday->id,'durum'=>1])}}">
                    <button type="button" class="btn btn-sm me-3" id="kyConfirmbtn" data-bs-dismiss="modal">
                        <!-- Onay SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                fill="#006644" />
                        </svg>
                        Kayıt Yenileme Onayla
                    </button>
                </a>

            </div>
        </div>
    </div>
</div>
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
                <form id="createInterviewForm">
                    <div class="mb-3">
                        <label for="interviewDate" class="form-label">Mülakat Tarihi</label>
                        <div class="d-flex">
                            <select class="form-select me-2" id="interviewDay">
                                <option selected>Gün</option>
                            </select>
                            <select class="form-select me-2" id="interviewMonth">
                                <option selected>Ay</option>
                            </select>
                            <select class="form-select" id="interviewYear">
                                <option selected>Yıl</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="interviewTime" class="form-label">Mülakat Saati</label>
                        <div class="d-flex">
                            <select class="form-select me-2 " id="interviewHour">
                                <option selected>Saat</option>
                            </select>
                            <select class="form-select" id="interviewMinute">
                                <option selected>Dakika</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 ">
                        <label for="interviewType">Mülakat Tipi</label>
                        <select name="modalinterviewType" class="form-select" id="modalinterviewType">
                            <option selected>Seçiniz</option>
                            <option value="Çevrim içi">Çevrim içi</option>
                            <option value="Yüz Yüze">Yüz Yüze</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="interviewLocation" class="form-label">Mülakat Yeri</label>
                        <input type="text" class="form-control" id="interviewLocation"
                               placeholder="Yer bilgisi giriniz..">
                    </div>
                    <div class="mb-3">
                        <label for="createinterviewer" class="form-label">Mülakat Yapacak Kişi</label>
                        <input type="text" class="form-control" id="createinterviewer"
                               placeholder="Kişi bilgisi giriniz..">
                    </div>
                    <div class="mb-3">
                        <label for="interviewer">Toplanti Link / Adres</label>
                        <input type="text" class="form-control" id="createinterviewmodaladdress"
                               placeholder="Yazınız..">

                    </div>
                    <button id="createInterviewCreateButton" type="submit"
                            class="btn btn-primary mt-3">Oluştur</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mülakatı Güncelle Modalı -->
<div class="modal fade" id="updateInterviewModal" tabindex="-1" aria-labelledby="updateInterviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="modal-title" id="updateInterviewModalLabel">Mülakat Düzenle</h5>
                    <p>Yapmak istediğiniz işlemi seçiniz</p>
                </div>
                <input type="hidden"  id="currentInterviewId">
                <button type="button" class="btn btn-primary mb-2" id="updateInterviewDetails">Mülakat Bilgilerini Güncelle</button>
                <button type="button" class="btn btn-primary" id="concludeInterview">Mülakat Sonuçlandır</button>
            </div>
        </div>
    </div>
</div>

<!-- Mülakat Bilgilerini Güncelle Modal -->
<div class="modal fade" id="interviewDetailsModal" tabindex="-1" aria-labelledby="interviewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h5 class="modal-title" id="interviewDetailsModalLabel">Mülakat Bilgilerini Güncelle</h5>
                </div>
                <form id="interviewDetailsForm">
                    <input type="hidden" id="interviewId" />
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="interviewDate" class="form-label">Mülakat Tarihi</label>
                            <input type="date" class="form-control" id="updateinterviewDate"  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="interviewTime" class="form-label">Mülakat Saati</label>
                            <input type="time" class="form-control" id="updateinterviewTime" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="interviewType" class="form-label">Mülakat Tipi</label>
                        <select class="form-select" id="updateinterviewType" required>
                            <option selected disabled>Seçiniz</option>
                            <option value="Çevrim içi">Çevrim içi</option>
                            <option value="Yüz Yüze">Yüz Yüze</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="updateinterviewer" class="form-label">Mülakatı Yapacak Kişi</label>
                        <input type="text" class="form-control" id="updateinterviewer" placeholder="Yazınız.." required>
                    </div>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mülakat Oluşturuldu Başarı Modalı -->
<div class="modal fade" id="createInterviewSuccessModal" tabindex="-1"
     aria-labelledby="createInterviewSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="green"
                     class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path
                        d="M10.97 4.97a.75.75 0 011.07 1.05L7.477 10.525a.75.75 0 01-1.064.02L4.324 8.448a.75.75 0 111.082-1.04l1.528 1.54 4.036-4.036z" />
                    <path d="M16 8A8 8 0 11.001 8a8 8 0 0115.999 0zM1.5 8a6.5 6.5 0 1013 0 6.5 6.5 0 00-13 0z" />
                </svg>
                <h5 class="mt-3">Mülakat başarıyla oluşturuldu</h5>
                <p>Aday e-posta ve mesaj yolu ile bilgilendirilecek</p>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
<!-- Mülakat Notları Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class="modal-title" id="noteModalLabel">Mülakat Notları</h5>
                <div class="form-group">
                    <label for="interviewNote">Mülakat Değerlendirmesi</label>
                    <textarea class="form-control" id="interviewNote" rows="4"
                              placeholder="Açıklama giriniz..."></textarea>
                </div>
                <button type="button" class="btn btn-primary mt-3" id="saveNoteButton">Kaydet</button>
            </div>
        </div>
    </div>
</div>
<!-- Mülakat Sonuçlandır Modalı -->
<div class="modal fade" id="concludeInterviewModal" tabindex="-1" aria-labelledby="concludeInterviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="concludeInterviewForm">
                    <input type="hidden" id="concludeInterviewId" />
                    <div class="text-center">
                        <h5 class="modal-title" id="concludeInterviewModalLabel">Mülakat Sonuçlandır</h5>
                        <p>Mülakat sonuçlarını giriniz</p>
                        <p>Güncelle butonuna bastığınızda aday otomatik olarak bilgilendirilecektir</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="interviewScore" class="form-label">Mülakat Puanı</label>
                            <input type="number" class="form-control" id="interviewScore" placeholder="Puan yazınız..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="interviewResult" class="form-label">Mülakat Sonucu</label>
                            <select class="form-select" id="interviewResult" required>
                                <option selected disabled>Seçiniz</option>
                                <option value="Olumlu">Olumlu</option>
                                <option value="Olumsuz">Olumsuz</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Mülakat Silme Modalı-->
<div class="modal fade" id="deleteInterviewModal" tabindex="-1" aria-labelledby="deleteInterviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="deleteInterviewModalLabel">Mülakat Başarıyla Silindi!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18.75 11.25L11.25 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.25 11.25L18.75 18.75" stroke="#FF0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p>Mülakatın neden silindiğini kısaca açıklayınız.</p>
                <form id="deleteInterviewForm" method="post" action="{{route('deletenewinterview')}}" > @csrf
                    <input type="hidden" name="mulakatid" id="mulakatid">
                    <div class="mb-3">
                        <textarea class="form-control" id="deleteReason" rows="3" name="mulakatsilmeaciklama" placeholder="Açıklama giriniz.." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </form>
                <p class="mt-3">Aday kişi açıklamanız doğrultusunda mesaj ve e-posta yolu ile bilgilendirilecektir!</p>
            </div>
        </div>
    </div>
</div>
<!-- Başvuru Formu Modal -->
<div class="modal fade" id="applicationFormModal" tabindex="-1" aria-labelledby="applicationFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="applicationFormModalLabel">Başvuru Formu</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" id="downloadPdf">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M16.6673 7.5H13.334V2.5H6.66732V7.5H3.33398L10.0007 14.1667L16.6673 7.5ZM3.33398 15.8333V17.5H16.6673V15.8333H3.33398Z" fill="white"/>
                        </svg>
                        PDF İndir
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
            <div class="modal-body w-100" id="applicationFormContent">
                <div class="container mt-3">
                    <div class="d-flex flex-row">
                        <!-- Genel Bilgiler -->
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between" >
                                <h3>Genel Bilgiler</h3>
                                @php $fotografPath = null; $fotografPath = $aday->infos->doc_fotograf;@endphp
                                <img  src="{{ $fotografPath ? url($fotografPath) : '../../assets/images/default-profile.svg' }}" alt="Profile Photo" class=" rounded-circle personcard-img img-fluid">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Adı</label>
                                    <input type="hidden" name="period_id" id="period_id" value="{{$aday->infos->period_id}}">
                                    <input id="name" type="text" class="form-control" value="{{$aday->infos->name}}" >
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Soyadı</label>
                                    <input id="surname" type="text" class="form-control" value="{{$aday->infos->surname}}" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">TC Kimlik Numarası</label>
                                    <input id="tc_no" type="text" class="form-control" value="{{$aday->infos->tc_no}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label id="email" class="custom-label">E-Posta</label>
                                    <input type="text" class="form-control" value="{{$aday->infos->email}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Telefon</label>
                                    <input id="tel_no" type="text" class=" telinputs form-control"
                                           value="{{$aday->infos->tel_no}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Şube</label>
                                    <input id="sube" type="text" class="form-control" value=" {{$aday->infos->sube}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Bursiyer Tipi</label>
                                    <select id="aday_turu" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option @if($aday->infos->aday_turu == 'Dernek') selected @endif value="Dernek">Dernek</option>
                                        <option @if($aday->infos->aday_turu == 'Vakıf') selected @endif value="Vakıf">Vakıf</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" @if($aday->infos->check_taahhutname == 'on') checked @endif id="check_taahhutname">
                                    <p class="form-check-label mt-1" for="check_taahhutname"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>Taahhütname'yi</u> okudum, kabul ediyorum
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" @if($aday->infos->check_ailebireyleri == 'on') checked @endif id="check_ailebireyleri">
                                    <p class="form-check-label mt-1 " for="check_ailebireyleri"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum, anladım.
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" @if($aday->infos->check_acikriza == 'on') checked @endif id="check_acikriza">
                                    <p class="form-check-label mt-1 " for="check_acikriza"
                                       style="cursor: pointer;"
                                       onclick="window.location.href='https://sacdd.org.tr/index.php/burs-fonu/kvkk';">
                                        <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" @if($aday->infos->check_acikriza == 'on') checked @endif id="check_acikriza">
                                    <p class="form-check-label mt-1 " for="check_acikriza"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" @if($aday->infos->check_aydinlatma == 'on') checked @endif id="check_aydinlatma">
                                    <p class="form-check-label mt-1 " for="check_aydinlatma"
                                       data-bs-toggle="modal" data-bs-target="#kvkkModal">
                                        <u>KVKK Kurallarının gereksinimlerini kabul ederim.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <input class="form-check-input" type="checkbox" @if($aday->infos->check_bilgidogrulama == 'on') checked @endif id="check_bilgidogrulama">
                                    <p class="form-check-label mt-1 " for="check_bilgidogrulama">
                                        Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve
                                        gerektiğinde
                                        araştırma yapılmasını kabul ediyorum.
                                    </p>
                                </div>

                            </div>
                            <hr>
                            <!-- Kişisel Bilgiler -->

                            <h3>Kişisel Bilgiler</h3>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="interviewDate">Doğum Tarihi</label>
                                    <div class="input-group">
                                        <input value="{{$aday->infos->b_dob}}" type="text" class="form-control inputDate" id="b_dob" placeholder="Tarih seçiniz">
                                        <div class="input-group-append no-border">
                                                                            <span class="input-group-text no-border" id="b_dobIcon">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                                    <path d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z"/>
                                                                                </svg>
                                                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu Şehir</label>
                                    <select id="born_city" class="form-select">
                                        @foreach($cities as $city)
                                            <option @if($aday->infos->born_city == $city->name) selected @endif data-id="{{$city->il_no}}" value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu İlçe</label>
                                    <select id="born_district" class="form-select">
                                        <option selected  value="{{$aday->infos->born_district}}">{{$aday->infos->born_district}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İl</label>
                                    <select id="registered_city" class="form-select">
                                        @foreach($cities as $city)
                                            <option @if($aday->infos->registered_city == $city->name) selected @endif data-id="{{$city->il_no}}" value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İlçe</label>
                                    <select id="registered_district" class="form-select">
                                        <option selected  value="{{$aday->infos->registered_district}}">{{$aday->infos->registered_district}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Cinsiyet</label>
                                    <select id="gender" class="form-select">
                                        <option @if($aday->infos->gender == 'Kadın') selected @endif value="Kadın">Kadın</option>
                                        <option @if($aday->infos->gender == 'Erkek') selected @endif value="Erkek">Erkek</option>
                                        <option @if($aday->infos->gender == 'Belirtmek İstemiyorum') selected @endif value="Belirtmek İstemiyorum">Belirtmek İstemiyorum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Medeni Durumu</label>
                                    <select id="maritality" class="form-select">
                                        <option @if($aday->infos->maritality == 'Bekar') selected @endif value="Bekar">Bekar</option>
                                        <option  @if($aday->infos->maritality == 'Evli') selected @endif value="Evli">Evli</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Uyruk</label>
                                    <select id="nationality" class="form-select">
                                        <option @if($aday->infos->nationality == 'Türkiye') selected @endif value="Türkiye">Türkiye</option>
                                        <option @if($aday->infos->nationality == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                    </select>
                                </div>
                            </div>
                            <hr>

                            <!-- Kişisel Bilgiler -->

                            <h3>Eğitim Bilgileri</h3>
                            <div class="row">
                                <div class="form-group">
                                <label class="custom-label">Eğitim Tipi</label>
                                <input id="educationType" type="text" class="form-control" value="{{$aday->infos->educationType}}">
                                @switch($aday->infos->educationType)

                                @case('ilkokul')
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Okul Tipi</label>
                                            <input id="primary_educ_type" type="text" class="form-control" value="{{$aday->infos->primary_educ_type}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Okul Adı</label>
                                            <input id="p_school_name" type="text" class="form-control" value="{{$aday->infos->p_school_name}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                            <input id="p_school_city" type="text" class="form-control" value="{{$aday->infos->p_school_city}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Sınıf</label>
                                            <input id="class" type="text" class="form-control" value="{{$aday->infos->class}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Öğrenci Numarası</label>
                                            <input id="student_number" type="text" class="form-control" value="{{$aday->infos->student_number}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Not Ortalaması</label>
                                            <input id="grade_avg" type="text" class="form-control" value=" {{$aday->infos->grade_avg}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Nakil Yaptı Mı</label>
                                            <input id="is_transfered" type="text" class="form-control" value="{{$aday->infos->is_transfered}}">
                                        </div>
                                    </div>
                                    @break

                                @case('ortaokul')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="schoolType">Okul Tipi</label>
                                            <select id="schoolType" class="form-select">
                                                <option disabled selected>Ortaokul</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="m_school_name">Okul Adı</label>
                                            <input  type="text" class="form-control"  @if(isset($aday->infos->m_school_name)) value="{{$aday->infos->m_school_name}}" @endif id="m_school_name"
                                                    placeholder="Okul adınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                                            <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                                                <option selected disabled>Şehir Seçiniz</option>
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if(isset($aday->infos->m_school_city ) && $aday->infos->m_school_city == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                                            <select id="m_school_district" class="form-select">
                                                @if(isset($aday->infos->m_school_district)) <option value="{{$aday->infos->m_school_district}} ">{{$aday->infos->m_school_district}}</option>@endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif" type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="class">Sınıfınız</label>
                                            <select id="class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '5') value="5">5</option>
                                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '6') value="6">6</option>
                                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '7') value="7">7</option>
                                                <option  @selected(isset($aday->infos->class) && $aday->infos->class == '8') value="8">8</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="transferred">Nakil Yaptı mı?</label>
                                            <select id="transferred" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Not Ortalaması</label>
                                            <input value="@if(isset($aday->infos->student_number)) {{$aday->infos->grade_avg}}@endif" type="text" class="form-control" id="student_number"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    @break
                                @case('lise')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="schoolType">Okul Tipi</label>
                                            <select id="schoolType" class="form-select">
                                                <option value="Lise">Lise</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="h_school_name">Okul Adı</label>
                                            <input value='{{$aday->infos->h_school_name}}' type="text" class="form-control" id="h_school_name"
                                                   placeholder="Okul adınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="h_school_city">Okulun Bulunduğu Şehir</label>
                                            <select onchange="getDistricts(this,'h_school_district')" id="h_school_city" class="form-select">
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if(isset($aday->infos->h_school_city ) && $aday->infos->h_school_city == $city->name) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="h_school_district">Okulun Bulunduğu İlçe</label>
                                            <select id="h_school_district" class="form-select">
                                                <option>{{$aday->infos->h_school_district}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value=" @if(isset($aday->infos->student_number)) {{$aday->infos->student_number}}@endif"  type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="class">Sınıfınız</label>
                                            <select id="class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '9')  value="9">9</option>
                                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '10')  value="10">10</option>
                                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '11')  value="11">11</option>
                                                <option @selected(isset($aday->infos->class) && $aday->infos->class == '12')  value="12">12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="is_transfered">Nakil Yaptı mı?</label>
                                            <select id="is_transfered" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Evet') value="Evet">Evet</option>
                                                <option  @selected(isset($aday->infos->is_transfered) && $aday->infos->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="averageGrade">Not Ortalaması</label>
                                            <input @if(isset($aday->infos->grade_avg)) value="{{$aday->infos->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    @break
                                @case('onlisans')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_high_school">Bitirdiğiniz Lise</label>
                                            <input @if(isset($aday->infos->grade_high_school)) value="{{$aday->infos->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                                                   placeholder="Lise bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                                            <input @if(isset($aday->infos->entry_grade_university)) value="{{$aday->infos->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                                                   placeholder="Puanınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_city">Okulun Bulunduğu Şehir</label>
                                            <select id="university_city" class="form-select">
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                                            <select id="current_university" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                @foreach($unis as $u)
                                                    <option data-id='{{$u->id}}' @selected(isset($aday->infos->current_university) && $aday->infos->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                                            <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                                                <option>Fakulte Seciniz</option>
                                                @if($aday->infos->university_faculty)
                                                    <option selected value="{{$aday->infos->university_faculty}}">{{$aday->infos->university_faculty}}</option>
                                                @endif
                                                </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                                            <select data-dataset="" class="form-select" name="grade_departmant" required="" id="grade_departmant">
                                                <option>Bölüm Seciniz</option>
                                                @if($aday->infos->grade_departmant)
                                                    <option selected value="{{$aday->infos->grade_departmant}}">{{$aday->infos->grade_departmant}}</option>
                                                @endif
                                                </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_type">Üniversitenin Statüsü</label>
                                            <select id="university_type" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Devlet') value="Devlet">Devlet</option>
                                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_types"> Öğrenim Türü</label>
                                            <select id="university_types" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Örgün') value="Örgün">Örgün</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="university_class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '1') value="1">1.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '2') value="2">2.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '3') value="3">3.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '4') value="4">4.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '5') value="5">5.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '6') value="6">6.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                            <select id="university_educ_time" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '2') value="2">2</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '3') value="3">3</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '4') value="4">4</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '5') value="5">5</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '6') value="6">6</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '7') value="7">7</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value='@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}} @endif'  type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agnoSystem">AGNO Sisteminiz</label>
                                            <select id="agnoSystem" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno">AGNO</label>
                                            <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="university_transfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                                <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                bilgilerinizi yazınız</label>
                                            <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                   placeholder="Geçiş bilgilerinizi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 form-group">
                                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                                yazınız</label>
                                            <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages">
                                        </div>
                                    </div>

                                    @break
                                @case('lisans')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_high_school">Bitirdiğiniz Lise</label>
                                            <input @if(isset($aday->infos->grade_high_school)) value="{{$aday->infos->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                                                   placeholder="Lise bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                                            <input @if(isset($aday->infos->entry_grade_university)) value="{{$aday->infos->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                                                   placeholder="Puanınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_city">Okulun Bulunduğu Şehir</label>
                                            <select id="university_city" class="form-select">
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                                            <select id="current_university" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                @foreach($unis as $u)
                                                    <option data-id='{{$u->id}}' @selected(isset($aday->infos->current_university) && $aday->infos->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                                            <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                                                <option>Fakulte Seciniz</option>
                                                @if($aday->infos->university_faculty)
                                                    <option selected value="{{$aday->infos->university_faculty}}">{{$aday->infos->university_faculty}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                                            <select data-dataset="" class="form-select" name="grade_departmant" required="" id="grade_departmant">
                                                <option>Bölüm Seciniz</option>
                                                @if($aday->infos->grade_departmant)
                                                    <option selected value="{{$aday->infos->grade_departmant}}">{{$aday->infos->grade_departmant}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_type">Üniversitenin Statüsü</label>
                                            <select id="university_type" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Devlet') value="Devlet">Devlet</option>
                                                <option @selected(isset($aday->infos->university_type) && $aday->infos->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_types"> Öğrenim Türü</label>
                                            <select id="university_types" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Örgün') value="Örgün">Örgün</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                                                <option @selected(isset($aday->infos->university_types) && $aday->infos->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="university_class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '1') value="1">1.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '2') value="2">2.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '3') value="3">3.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '4') value="4">4.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '5') value="5">5.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == '6') value="6">6.Sınıf</option>
                                                <option @selected(isset($aday->infos->university_class) && $aday->infos->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                            <select id="university_educ_time" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '2') value="2">2</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '3') value="3">3</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '4') value="4">4</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '5') value="5">5</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '6') value="6">6</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '7') value="7">7</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value='@if(isset($aday->infos->student_number)) {{$aday->infos->student_number}} @endif'  type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agnoSystem">AGNO Sisteminiz</label>
                                            <select id="agnoSystem" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno">AGNO</label>
                                            <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="university_transfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                                <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                bilgilerinizi yazınız</label>
                                            <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                   placeholder="Geçiş bilgilerinizi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 form-group">
                                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                                yazınız</label>
                                            <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages">
                                        </div>
                                    </div>

                                    @break
                                @case('yukseklisans')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_university">Bitirdiğiniz Üniversite</label>
                                            <input  @if(isset($aday->infos->grade_university)) value="{{$aday->infos->grade_university}}" @endif type="text" class="form-control" id="grade_university"
                                                    placeholder="Üniversite bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_departmant">Mezun Olduğunuz Bölüm</label>
                                            <input type="text" @if(isset($aday->infos->grade_departmant)) value="{{$aday->infos->grade_departmant}}" @endif class="form-control" id="grade_departmant"
                                                   placeholder="Puanınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                                            <select id="university_city" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if( isset($aday->infos->university_city) && $aday->infos->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="masterUniversity">Yüksek Lisans Yaptığınız Üniversite</label>
                                            <select id="masterUniversity" class="form-select">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="master_field">Yüksek Lisans Yaptığınız Dal</label>
                                            <input @if(isset($aday->infos->master_field)) value="{{$aday->infos->master_field}}" @endif type="text" class="form-control" id="master_field"
                                                   placeholder="Dal bilgisi giriniz...">
                                        </div>

                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input @if(isset($aday->infos->student_number)) value="{{$aday->infos->student_number}}" @endif  type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="educationYear" class="form-select">
                                                <option value="">Seçiniz...</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                            <select id="university_educ_time" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '2') value="2">2</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '3') value="3">3</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '4') value="4">4</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '5') value="5">5</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '6') value="6">6</option>
                                                <option @selected(isset($aday->infos->departmentYear) && $aday->infos->departmentYear == '7') value="7">7</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_agno">Mezuniyet AGNO</label>
                                            <input  @if(isset($aday->infos->grade_agno)) value="{{$aday->infos->grade_agno}}" @endif type="text" class="form-control" id="grade_agno"
                                                    placeholder="Agno giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno_type">AGNO Sisteminiz</label>
                                            <select id="agno_type" class="form-select">
                                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                <option @selected(isset($aday->infos->agno_type) && $aday->infos->agno_type == "100'lük") value="100'lük">100'lük</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno">AGNO</label>
                                            <input value="@if(isset($aday->infos->agno)) {{$aday->infos->agno}} @endif" type="text" class="form-control" id="agno"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="university_transfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Evet" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Evet')>Evet</option>
                                                <option value="Hayır" @selected(isset($aday->infos->university_transfer) && $aday->infos->university_transfer == 'Hayır')>Hayır</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                bilgilerinizi yazınız</label>
                                            <input value="@if(isset($aday->infos->university_transfer_desc)) {{$aday->infos->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                   placeholder="Geçiş bilgilerinizi giriniz...">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 form-group">
                                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                            yazınız</label>
                                        <input value="@if(isset($aday->infos->languages)) {{$aday->infos->languages}} @endif" type="text" class="form-control" id="languages"
                                               placeholder="Dil (seviye) şeklinde, araya virgül (,) koyarak sıralayınız">
                                    </div>

                                    @break
                            @endswitch
                            </div>
                           <hr>
                           <!--  Kalinan Yer  Bilgileri -->
                           <h3>Kalan Yer Bilgileri</h3>
                           <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Barınma Türü</label>
                                <select id="housing_type" class="form-select">
                                    <option @if($aday->infos->housing_type == 'Öğrenci Evi') selected @endif  value="Öğrenci Evi">Öğrenci Evi</option>
                                    <option @if($aday->infos->housing_type == 'Yurt') selected @endif value="Yurt">Yurt</option>
                                    <option @if($aday->infos->housing_type == 'Aile Yanı') selected @endif value="Aile Yanı">Aile Yanı</option>
                                    <option @if($aday->infos->housing_type == 'Misafir') selected @endif value="Misafir">Misafir</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Ödenen Ücret</label>
                                <input id="housing_fee" type="text" class="form-control" value="{{$aday->infos->housing_fee}}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Birlikte Yaşanılan Kişi Sayısı</label>
                                <input id="living_with_count" type="text" class="form-control"
                                       value="{{$aday->infos->living_with_count}}">

                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Kaldığı İl</label>
                                <select id="residing_city" class="form-select">
                                    @foreach($cities as $city)
                                        <option  data-id="{{$city->id}}" @if($aday->infos->residing_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Kaldığı İlçe</label>
                                <select id="residing_district" class="form-select">
                                    <option  selected value="{{$aday->infos->residing_district}}">{{$aday->infos->residing_district}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Tam Adres</label>
                                <input id="address_detail" type="text" class="form-control"
                                       value="{{$aday->infos->address_detail}}">
                            </div>
                           </div>

                           <hr>
                           <!--  Aile Adresi Bilgileri -->
                           <h3>Aile Adres Bilgileri</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Yaşadığı İl</label>
                                    <select id="mother_city" class="form-select">
                                        <option value="">Seçiniz</option>

                                        @foreach($cities as $city)
                                            <option  data-id="{{$city->id}}" @if($aday->infos->mother_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Yaşadığı İl</label>
                                    <select id="father_city" class="form-select">
                                        <option value="">Seçiniz</option>
                                        @foreach($cities as $city)
                                            <option  data-id="{{$city->id}}" @if($aday->infos->father_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Yaşadığı İlçe</label>
                                    <option value="">Seçiniz</option>

                                    <select id="mother_district" class="form-select">
                                        <option  selected value="{{$aday->infos->mother_district}}">{{$aday->infos->mother_district}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Yaşadığı İlçe</label>
                                    <option value="">Seçiniz</option>

                                    <select id="father_district" class="form-select">
                                        <option  selected value="{{$aday->infos->father_district}}">{{$aday->infos->father_district}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Açık Adres</label>
                                    <input id="parent_address" type="text" class="form-control"
                                           value="{{$aday->infos->parent_address}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label" for="phone">Aile Cep Telefonu</label>
                                    <br>
                                    <input type="tel" id="parent_mobile" value="{{$aday->parent_mobile}}" class="form-control telinputs" placeholder="+90 506 144 5288"
                                           style="width:390px ; ">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aile Ev Telefonu</label>
                                    <input id="parent_phone" type="text" class="form-control"
                                           value="{{$aday->infos->parent_phone}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aile E-posta Adresi</label>
                                    <input id="parent_email" type="text" class="form-control"
                                           value="{{$aday->infos->parent_email}}">
                                </div>
                            </div>
                            <div class="urgent">
                                <div class="row">
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"
                                                fill="black" />
                                        </svg> Acil Durum Kişisi</p>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Ad</label>
                                        <input type="text" class="form-control " id="emergency_person_name" value="{{$aday->infos->emergency_person_name}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Soyad</label>
                                        <input type="text" class="form-control " id="emergency_person_surname" value="{{$aday->infos->emergency_person_surname}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Yakınlık Derecesi</label>
                                        <input type="text" class="form-control " id="emergency_closeness" value="{{$aday->infos->emergency_closeness}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Cep Telefonu</label>
                                        <input type="text" class="form-control telinputs " id='emergency_mobile' value="{{$aday->infos->emergency_mobile}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">E-Posta Adresi</label>
                                        <input type="text" class="form-control " value="">
                                    </div>
                                </div>
                            </div>
                           </div>
                           <hr>
                           <!-- Ebeveyn Bilgileri -->
                           <h3>Ebeveyn Bilgileri</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Anne Baba Birlikte Mi?</label>
                                    <select id="parent_together" class="form-select">
                                        <option @if($aday->infos->parent_together == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->parent_together == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Anne Sağ Mı?</label>
                                    <select id="mother_alive" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option @if($aday->infos->mother_alive == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->mother_alive == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Baba Sağ Mı?</label>
                                    <select id="mother_alive" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option @if($aday->infos->C9l7SUqOxSvZ == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->C9l7SUqOxSvZ == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Anne Ad </label>
                                    <input id="mother_name" type="text" class="form-control" value="{{$aday->infos->mother_name}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Anne Soyad</label>
                                    <input id="mother_surname"  value="{{$aday->infos->mother_surname}}" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Baba Ad</label>
                                    <input id="father_name" type="text" class="form-control" value="{{$aday->infos->father_name}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Baba Soyad</label>
                                    <input id="father_surname"  value="{{$aday->infos->father_surname}}" type="text" class="form-control">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Mesleği</label>
                                    <input id="mother_job" type="text" class="form-control" value="{{$aday->infos->mother_job}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Mesleği</label>
                                    <input id="father_job" type="text" class="form-control" value="{{$aday->infos->father_job}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Tahsil Durumu</label>
                                    <select class="form-select" id="mother_educ">
                                         <option @if($aday->infos->mother_educ == 'İlkokul') selected @endif  value="İlkokul">İlkokul</option>
                                         <option @if($aday->infos->mother_educ == 'Ortaokul') selected @endif  value="Ortaokul">Ortaokul</option>
                                         <option @if($aday->infos->mother_educ == 'Lise') selected @endif  value="Lise">Lise</option>
                                         <option @if($aday->infos->mother_educ == 'Ön Lisans') selected @endif  value="Ön Lisans">Ön Lisans</option>
                                         <option @if($aday->infos->mother_educ == 'Lisans') selected @endif  value="Lisans">Lisans</option>
                                         <option @if($aday->infos->mother_educ == 'Yüksek Lisans') selected @endif  value="Yüksek Lisans">Yüksek Lisans</option>
                                         <option @if($aday->infos->mother_educ == 'Doktora') selected @endif  value="Doktora">Doktora</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Tahsil Durumu</label>
                                    <select class="form-select" id="father_educ">
                                        <option @if($aday->infos->father_educ == 'İlkokul') selected @endif  value="İlkokul">İlkokul</option>
                                        <option @if($aday->infos->father_educ == 'Ortaokul') selected @endif  value="Ortaokul">Ortaokul</option>
                                        <option @if($aday->infos->father_educ == 'Lise') selected @endif  value="Lise">Lise</option>
                                        <option @if($aday->infos->father_educ == 'Ön Lisans') selected @endif  value="Ön Lisans">Ön Lisans</option>
                                        <option @if($aday->infos->father_educ == 'Lisans') selected @endif  value="Lisans">Lisans</option>
                                        <option @if($aday->infos->father_educ == 'Yüksek Lisans') selected @endif  value="Yüksek Lisans">Yüksek Lisans</option>
                                        <option @if($aday->infos->father_educ == 'Doktora') selected @endif  value="Doktora">Doktora</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Bağlı Olduğu Sosyal Güvenlik
                                        Kurumu</label>
                                    <select class="form-select" id="mother_company">
                                        <option @if($aday->infos->mother_company == 'SGK') selected @endif  value="SGK">SGK</option>
                                        <option @if($aday->infos->mother_company == 'BAĞ-KUR') selected @endif value="BAĞ-KUR">BAĞ-KUR</option>
                                        <option @if($aday->infos->mother_company == 'Yok') selected @endif value="Yok">Yok</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                                        Kurumu</label>
                                    <select class="form-select" id="father_company">
                                        <option @if($aday->infos->father_company == 'SGK') selected @endif value="SGK">SGK</option>
                                        <option @if($aday->infos->father_company == 'BAĞ-KUR') selected @endif value="BAĞ-KUR">BAĞ-KUR</option>
                                        <option @if($aday->infos->father_company == 'Yok') selected @endif value="Yok">Yok</option>
                                    </select>
                                </div>
                            </div>
                           </div>
                           <hr>
                           <!-- Kardeş Bilgileri -->
                           <h3>Kardeş Bilgileri</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kardeş Sayısı</label>
                                    <select id="count" class="form-select">
                                        <option value="">Seçiniz</option>
                                        <option @if($aday->infos->count == 1) selected @endif value="1">1</option>
                                        <option @if($aday->infos->count == 2) selected @endif value="2">2</option>
                                        <option @if($aday->infos->count == 3) selected @endif value="3">3</option>
                                        <option @if($aday->infos->count == 4) selected @endif value="4">4</option>
                                        <option @if($aday->infos->count == '5 ve üzeri') selected @endif value="5 ve üzeri">5 ve üzeri</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kendisi Dahil Okuyan Kardeş Sayısı</label>
                                    <input id="educ_count" type="number" class="form-control" value="{{$aday->infos->educ_count}}">
                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Adı</th>
                                    <th>Soyadı</th>
                                    <th>Yaşı</th>
                                    <th>Öğrenim Durumu</th>
                                    <th>Medeni Durumu</th>
                                    <th>Mesleği (Çalışıyorsa)</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($aday->scholar->kardesler as $kardes)
                                    <tr>
                                        <td>{{$kardes->name}}</td>
                                        <td>{{$kardes->surname}}</td>
                                        <td>{{$kardes->age}}</td>
                                        <td>{{$kardes->educ_status}}</td>
                                        <td>{{$kardes->maritality}}</td>
                                        <td>{{$kardes->job}}</td>

                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                           </div>
                           <hr>
                           <!-- Gelir Bilgileri -->
                           <h3>Gelir Beyanı</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Geçmişini Kim/Kimler
                                        Sağlıyor?</label>
                                    <input id="income_person" type="text" class="form-control" value="{{$aday->infos->income_person}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç
                                        Kişiye
                                        Bakıyor?</label>
                                    <input id="total_person" type="number" class="form-control" value="{{$aday->infos->total_person}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                                    <input id="mother_salary" type="text" class="form-control"
                                           value="{{$aday->infos->mother_salary}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                                    <input id="father_salary" type="text" class="form-control"
                                           value="{{$aday->infos->father_salary}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Diğer Kişilerin Aylık Net Geliri
                                        (TL)</label>
                                    <input id="other_salary" type="text" class="form-control"
                                           value="{{$aday->infos->other_salary}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Başka Geliri Var Mı?</label>
                                    <input id="other_income" type="text" class="form-control" value="{{$aday->infos->other_income}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                                    <select class="form-select" id="parent_housing_type" required>
                                        <option selected disabled>Seçiniz...</option>
                                       <option @if($aday->infos->parent_housing_type == 'Kendi Evi') selected @endif value="Kendi Evi">Kendi Evi</option>
                                       <option @if($aday->infos->parent_housing_type == 'Kiralık') selected @endif value="Kiralık">Kiralık</option>
                                       <option @if($aday->infos->parent_housing_type == 'Misafir') selected @endif value="Misafir">Misafir</option>
                                       <option @if($aday->infos->parent_housing_type == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                                    <input id="rent_count" type="text" class="form-control" value="{{$aday->infos->rent_count}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Diğer</label>
                                    <input id="other_detail" type="text" class="form-control" value="{{$aday->infos->other_detail}}">
                                </div>
                            </div>
                           </div>
                           <hr>
                           <!-- Diger Burs Bilgileri -->
                           <h3>Diger Burs Bilgileri</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Devlet Bursu Almakta mı ya da Başvurdu
                                        mu?</label>
                                    <select id="government" class="form-select">
                                        <option @if($aday->infos->government == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->government == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Özel Burs Almakta ya da Başvurdu mu?</label>
                                    <select id="special" class="form-select">
                                        <option @if($aday->infos->special == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->special == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Burs</th>
                                    <th>Kurum Türü</th>
                                    <th>Kurum Adı</th>
                                    <th> Burs Tutarı</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($aday->infos->otherScholarships as $sc)
                                    <tr>
                                        <td></td>
                                        <td>{{$sc->company_name}}</td>
                                        <td>{{$sc->company_type}}</td>
                                        <td>{{$sc->count}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                           </div>
                           <hr>

                           <!-- Engellilik Bilgileri -->
                           <h3>Engel Durumu</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Herhangi Bir Engeliniz Var mı?</label>
                                    <select id="disabled_status" class="form-select">
                                        <option @if($aday->infos->disabled_status == 'Evet') selected @endif  value="Evet">Evet</option>
                                        <option @if($aday->infos->disabled_status == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Engel Durumunu Açıklayınız (Varsa)</label>
                                    <input id="disabled_detail" type="text" class="form-control" value="{{$aday->infos->disabled_detail}}">
                                </div>
                            </div>
                           </div>
                            <hr>

                            <!-- Sosyal Durum Bilgileri -->
                            <h3>Sosyal Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Bizden Nasıl Haberdar Oldunuz?</label>
                                        <select class="form-select" id="platform" required>
                                            <option selected disabled>Seçiniz...</option>
                                            <option @if($aday->infos->platform == 'Sosyal Medya') selected @endif value="Sosyal Medya">Sosyal Medya</option>
                                            <option @if($aday->infos->platform == 'Web Sitesi') selected @endif value="Web Sitesi">Web Sitesi</option>
                                            <option @if($aday->infos->platform == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Güçlü Yanlarınızın Ne olduğunu
                                            Düşünüyorsunuz?</label>
                                        <input id="skills" type="text" class="form-control" value="{{$aday->infos->skills}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Katkıda Bulunduğunuz Sosyal Projeler</label>
                                        <input id="social_projects" type="text" class="form-control"
                                               value="{{$aday->infos->social_projects}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Hobileriniz</label>
                                        <input id="hobbies" type="text" class="form-control" value="{{$aday->infos->hobbies}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
                                        <input id="sports" type="text" class="form-control" value="{{$aday->infos->sports}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Son Okuduğunuz Kitaplar</label>
                                        <input id="last_books" type="text" class="form-control"
                                               value="{{$aday->infos->last_books}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Bize Mesajınız</label>
                                        <input id="message" type="text" class="form-control"
                                               value="{{$aday->infos->message}}">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- Hesap Bilgileri -->
                            <h3>Hesap Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Banka</label>
                                        <select id="bank_name" class="form-select">
                                            <option @if($aday->infos->bank_name == 'Vakıfbank') selected @endif value="Vakıfbank">Vakıfbank</option>
                                            <option @if($aday->infos->bank_name == 'Ziraat Bankası') selected @endif value="Ziraat Bankası">Ziraat Bankası</option>
                                            <option @if($aday->infos->bank_name == 'İş Bankası') selected @endif value="İş bankası">İş Bankası</option>
                                            <option @if($aday->infos->bank_name == 'FinansBank') selected @endif value="FinansBank">FinansBank</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="iban" class="form-label">IBAN</label>
                                            <input type="text" class="form-control" id="iban"
                                                   value="{{$aday->infos->iban}}" maxlength="26">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="custom-label">Hesap Numarası</label>
                                            <input id="account_number" type="text" class="form-control"
                                                   value="{{$aday->infos->account_number}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- İş Bilgileri -->
                            <h3>İş Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Düzenli olarak bir kurumda kazanç sağlıyor
                                            mu?</label>
                                        <select id="is_working" class="form-select">
                                            <option @if($aday->infos->is_working == 'Full-time') selected @endif  value="Full-time">Full-time</option>
                                            <option @if($aday->infos->is_working == 'Part-time') selected @endif value="Part-time">Part-time</option>
                                            <option @if($aday->infos->is_working == 'Stajyer') selected @endif value="Stajyer">Stajyer</option>
                                            <option @if($aday->infos->is_working == 'Hayır') selected @endif value="Hayır">Hayır</option>
                                            <option @if($aday->infos->is_working == 'Diğer') selected @endif value="Diğer">Diğer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Kurum Adı</label>
                                        <input id="job_company" type="text" class="form-control" value="{{$aday->infos->job_company}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Görev</label>
                                        <input id="job_rank" type="text" class="form-control" value="{{$aday->infos->job_rank}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Sosyal Güvenlik Kurumu</label>
                                        <input id="job_sgk" type="text" class="form-control" value="{{$aday->infos->job_sgk}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Aylık Net Ücret (TL)</label>
                                        <input id="job_salary" type="text" class="form-control" value="{{$aday->infos->job_salary}}">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Burs Onaylandı Modali -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
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
                <h5 class="mt-3">Burs onaylanacak ve öğrenci bursiyerler alanına taşınacaktır.</h5>
                <span>Onaylıyor musunuz?</span>
                <p>Aday mesaj ve e-posta yolu ile bilgilendirilecektir.</p>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Vazgeç</button>
               <button type="button" class="btn btn-outline-success" id="confirmbtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path
                                d="M11.6673 11.8766V13.6178C11.146 13.4335 10.5851 13.3333 10.0007 13.3333C7.23923 13.3333 5.00065 15.5718 5.00065 18.3333H3.33398C3.33398 14.6513 6.31875 11.6666 10.0007 11.6666C10.5762 11.6666 11.1347 11.7395 11.6673 11.8766ZM10.0007 10.8333C7.23815 10.8333 5.00065 8.59575 5.00065 5.83325C5.00065 3.07075 7.23815 0.833252 10.0007 0.833252C12.7632 0.833252 15.0007 3.07075 15.0007 5.83325C15.0007 8.59575 12.7632 10.8333 10.0007 10.8333ZM10.0007 9.16658C11.8423 9.16658 13.334 7.67492 13.334 5.83325C13.334 3.99158 11.8423 2.49992 10.0007 2.49992C8.15898 2.49992 6.66732 3.99158 6.66732 5.83325C6.66732 7.67492 8.15898 9.16658 10.0007 9.16658ZM14.8281 16.5951L17.7743 13.6488L18.9528 14.8273L14.8281 18.9521L11.8818 16.0058L13.0603 14.8273L14.8281 16.5951Z"
                                fill="#006644" />
                        </svg>
                        Burs Onay
                    </button>
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
                <form action="{{route('addNewScholarSibling')}}" id="addSiblingForm" method="post"> @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kardesAdi" class="form-label">Adı</label>
                            <input name="name" type="text" class="form-control" id="kardesAdi" placeholder="Ad giriniz...">
                            <input name="tc_no" value="{{$aday->tc_no}}" type="hidden" class="form-control" id="tc_no" placeholder="Ad giriniz...">
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
                                <option>Boşanmış</option>

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
                <form method="post" action="{{route('editNewSiblingDetail')}}" id="editSiblingForm"> @csrf
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
                <form action="{{route('addNewScholarScholarShip')}}" method="post" id="addBursForm">@csrf
                    <input name="tc_no" value="{{$aday->tc_no}}" type="hidden" class="form-control" id="tc_no" placeholder="Ad giriniz...">
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
                <form action="{{route('editNewScholarsDetail')}}" method="post" id="editBursForm"> @csrf
                    <div class="row">
                        <input type="hidden" name="id" id="editbursid">
                        <div class="col-md-12 mb-3">
                            <label for="editkurumAdi" class="form-label">Burs Aldığınız Kurumun Adı</label>
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
<div class="modal fade" id="missingDocumentModal" tabindex="-1" aria-labelledby="missingDocumentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM13.75 18.75V21.25H16.25V18.75H13.75ZM13.75 8.75V16.25H16.25V8.75H13.75Z" fill="#636363"/>
                </svg>
                <h5 class="mt-3">Başvuru iade edildi !</h5>
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
                <button id="to-returnbtn" type="button" class="btn btn-primary" data-bs-dismiss="modal"> Başvuru İade Et </button>
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
                <h5 class="mt-3">Başvuru reddedildi !</h5>
                <p>Ret sebebini açıklayınız.</p>
                <div class="col-md-12 mb-3">
                    <label for="redSebebi" class="form-label">Ret Sebebi</label>
                    <select id="redSebebi" class="form-select">
                        <option >Ret sebebini seçiniz</option>
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
                <button id="deniedmodalbtn" type="button" class="btn btn-primary mt-3">Başvuruyu Reddet</button>
            </div>
        </div>
    </div>
</div>
<!-- Ön değerlendirme Onayla Modalı -->
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
                <h5 class="mt-3">Ön değerlendirme süreci onaylandı!</h5>
                <p>Aday mesaj ve e-posta yolu ile bilgilendirilecektir.</p>
                <a  href="{{url('panel/onay')}}/{{$aday->id}}"> <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Burs Onayla</button></a>
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
                    <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="interviewDate">Mülakat Tarihi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control inputDate" id="interviewDate" placeholder="Tarih seçiniz">
                                    <div style="z-index:3" class="input-group-append no-border">
                                                                <span class="input-group-text no-border" id="interviewDateIcon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                        <path d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z"/>
                                                                    </svg>
                                                                </span>
                                    </div>
                                </div>
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
                            <select name="person" class="form-select" id="interviewer">
                                <option selected>Seçiniz</option>
                                @foreach($mulakatGruplar as $mulakatGrup)
                                    <option value="{{ $mulakatGrup->id }}">{{ $mulakatGrup->name }}</option>
                                @endforeach
                            </select>                        </div>
                        <div class="col-md-12 form-group">
                            <label for="meetingLink">Toplantı Linki / Adresi</label>
                            <input name="address" type="text" class="form-control" id="meetingLink" placeholder="Yazınız..">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="interviewDescription">Mülakat Açıklaması</label>
                            <textarea name="detail" class="form-control" id="interviewDescription" rows="3" placeholder="Yazınız.."></textarea>
                        </div>
                    </div>
                    <button id="createInterviewCreateButton" type="submit"
                            class="btn btn-primary mt-3">Oluştur</button>
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
                <button type="button" onclick='location.reload();' id="confirmmodalbtn" class="btn btn-primary" data-bs-dismiss="modal">Kapat</button>
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
                <form action="{{route('end-interview')}}" method="post" id="concludeInterviewForm">@csrf
                    <input type="hidden" name="id" id="concludeInterviewId" />
                    <div class="text-center">
                        <h5 class="modal-title" id="concludeInterviewModalLabel">Mülakat Sonuçlandır</h5>
                        <p>Mülakat sonuçlarını giriniz</p>
                        <p>Güncelle butonuna bastığınızda aday otomatik olarak bilgilendirilecektir</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="interviewScore" class="form-label">Mülakat Puanı</label>
                            <input type="number" class="form-control" name="editinterviewScore" id="editinterviewScore" placeholder="Puan yazınız..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="interviewResult" class="form-label">Mülakat Sonucu</label>
                            <select class="form-select" name="editinterviewResult" id="editinterviewResult" required>
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
        <div class="modal-content" style="width: auto;">
            <div class="modal-header">

                <h5 class="modal-title" id="deleteInterviewModalLabel">Mülakat Silinecek!</h5>
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
<!-- Mülakatı Güncelle Modalı -->
<div class="modal fade" id="updateInterviewModal" tabindex="-1" aria-labelledby="updateInterviewModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text center">
                    <h5 class="modal-title" id="updateInterviewModalLabel">Mülakat Düzenle</h5>
                    <p>Yapmak istediğiniz işlemi seçiniz</p>
                </div>
                <button type="button" class="btn btn-primary mb-2" id="updateInterviewDetails">Mülakat Bilgilerini
                    Güncelle</button>
                <button type="button" class="btn btn-primary" id="concludeInterview">Mülakat Sonuçlandır</button>
            </div>
        </div>
    </div>
</div>
<!-- Mülakatı Ata Modalı -->
<div class="modal fade" id="mulakatAtaModal" tabindex="-1" aria-labelledby="mulakatAtaModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body w-100">
                <div class="text center">
                    <h5 class="modal-title" id="mulakatAtaModalLabel">Mülakat Ata</h5>
                    <p>Mülakatı atamak istediğiniz kişiyi seçiniz</p>
                </div>
                <form action="{{route('mulakat-ata')}}" method="post" id="mulakatAtaForm"> @csrf
                    <input type="hidden" name="mulakat_aday_id" id="mulakat_aday_id" value="{{$aday->id}}">
                    <div class="form-group">
                        <select name="mulakatAta" id="mulakatAta" class="form-select">
                        <option selected disabled>Seçiniz</option>
                    @foreach($mulakatGruplar as $grup)
                        <option value="{{ $grup->id }}">{{ $grup->name }}</option>
                    @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" id="mulakatAtaBtn">Mülakat Ata</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Mülakat Bilgileri Güncelle Modal -->
<div class="modal fade" id="interviewDetailsModal" tabindex="-1" aria-labelledby="interviewDetailsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center">
                    <h5 class="modal-title" id="interviewDetailsModalLabel">Mülakat Bilgilerini Güncelle</h5>
                </div>
                <form action="{{route('update-interview')}}" method="post" id="interviewDetailsForm"> @csrf
                    <div class="row">
                        <input type="hidden" name="id" id="editmulakatid">
                        <div class="col-md-6 form-group">
                            <label for="editinterviewDate">Mülakat Tarihi</label>
                            <div class="input-group">
                                <input type="text" class="form-control inputDate"  name="editinterviewDate" id="editinterviewDate" placeholder="Tarih seçiniz">
                                <div style="z-index: 3;" class="input-group-append no-border">
                                                                <span class="input-group-text no-border" id="editinterviewDateIcon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                        <path d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z"/>
                                                                    </svg>
                                                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editinterviewTime" class="form-label">Mülakat Saati</label>
                            <input name="editinterviewTime"  type="time" class="form-control" id="editinterviewTime" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editinterviewType" class="form-label">Mülakat Tipi</label>
                        <select name="editinterviewType" class="form-select" id="editinterviewType" required>
                            <option selected disabled>Seçiniz</option>
                            <option value="Çevrim içi">Çevrim içi</option>
                            <option value="Yüz Yüze">Yüz Yüze</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editinterviewer" class="form-label">Mülakatı Yapacak Kişi</label>
                        <select name="editinterviewer" class="form-select" id="editinterviewer" required>
                            <option value="" selected disabled>Seçiniz</option>
                            @foreach($mulakatGruplar as $grup)
                                <option value="{{ $grup->id }}">{{ $grup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editinterviewadress" class="form-label">Adres/Link</label>
                        <input name="editinterviewadress" type="text" class="form-control" id="editinterviewadress" placeholder="Adres/Link Yazınız.." required>
                    </div>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </form>
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
                                @php $fotografPath = null; $fotografPath = $aday->doc_fotograf;@endphp
                                <img  src="{{ $fotografPath ? url($fotografPath) : '../../assets/images/default-profile.svg' }}" alt="Profile Photo" class=" rounded-circle personcard-img img-fluid">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Adı</label>
                                    <input type="hidden" name="period_id" id="period_id" value="{{$aday->period_id}}">
                                    <p>
                                        {{$aday->name}}
                                    </p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Soyadı</label>
                                    <p>
                                        {{$aday->surname}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">TC Kimlik Numarası</label>
                                    <p>
                                        {{$aday->tc_no}}
                                    </p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label id="email" class="custom-label">E-Posta</label>
                                    <p>
                                        {{$aday->email}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Telefon</label>
                                    <p>
                                        {{$aday->tel_no}}
                                    </p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Şube</label>
                                    <p>
                                        {{$aday->sube}}
                                    </p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Bursiyer Tipi</label>
                                    <p>
                                        {{$aday->aday_turu}}
                                    </p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aday No.</label>
                                    <p>
                                        {{$aday->id}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if($aday->check_taahhutname == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>Taahhütname'yi</u> okudum, kabul ediyorum
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if($aday->check_ailebireyleri == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum, anladım.
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if($aday->check_acikriza == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if($aday->check_acikriza == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if($aday->check_aydinlatma == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>KVKK Kurallarının gereksinimlerini kabul ederim.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if($aday->check_bilgidogrulama == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
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
                                    <label class="custom-label">Doğum Tarihi</label>
                                    <p>{{$aday->b_dob}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu Şehir</label>
                                    <p>{{$aday->born_city}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu İlçe</label>
                                    <p>{{$aday->born_district}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İl</label>
                                    <p>{{$aday->registered_city}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İlçe</label>
                                    <p>{{$aday->registered_district}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Cinsiyet</label>
                                    <p>{{$aday->gender}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Medeni Durumu</label>
                                    <p>{{$aday->maritality}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Uyruk</label>
                                    <p>{{$aday->nationality}}</p>
                                </div>
                            </div>
                            <hr>

                            <!-- Kişisel Bilgiler -->

                            <h3>Eğitim Bilgileri</h3>
                            <div class="row">
                                <div class="form-group">
                                <label class="custom-label">Eğitim Tipi</label>
                                <p>{{$aday->educationType}}</p>
                                @switch($aday->educationType)

                                @case('ilkokul')
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Okul Tipi</label>
                                            <p>{{$aday->primary_educ_type}}</p>
                                            <input id="primary_educ_type" type="text" class="form-control" value="{{$aday->primary_educ_type}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Okul Adı</label>
                                            <input id="p_school_name" type="text" class="form-control" value="{{$aday->p_school_name}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                            <input id="p_school_city" type="text" class="form-control" value="{{$aday->p_school_city}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Sınıf</label>
                                            <input id="class" type="text" class="form-control" value="{{$aday->class}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Öğrenci Numarası</label>
                                            <input id="student_number" type="text" class="form-control" value="{{$aday->student_number}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Not Ortalaması</label>
                                            <input id="grade_avg" type="text" class="form-control" value=" {{$aday->grade_avg}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Nakil Yaptı Mı</label>
                                            <input id="is_transfered" type="text" class="form-control" value="{{$aday->is_transfered}}">
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
                                            <input  type="text" class="form-control"  @if(isset($aday->m_school_name)) value="{{$aday->m_school_name}}" @endif id="m_school_name"
                                                    placeholder="Okul adınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                                            <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                                                <option selected disabled>Şehir Seçiniz</option>
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if(isset($aday->m_school_city ) && $aday->m_school_city == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                                            <select id="m_school_district" class="form-select">
                                                @if(isset($aday->m_school_district)) <option value="{{$aday->m_school_district}} ">{{$aday->m_school_district}}</option>@endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value="@if(isset($aday->student_number)) {{$aday->student_number}}@endif" type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="class">Sınıfınız</label>

                                            <select id="class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option  @selected(isset($aday->class) && $aday->class == '5') value="5">5</option>
                                                <option  @selected(isset($aday->class) && $aday->class == '6') value="6">6</option>
                                                <option  @selected(isset($aday->class) && $aday->class == '7') value="7">7</option>
                                                <option  @selected(isset($aday->class) && $aday->class == '8') value="8">8</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="transferred">Nakil Yaptı mı?</label>
                                            <select id="transferred" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Evet') value="Evet">Evet</option>
                                                <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Not Ortalaması</label>
                                            <input value="@if(isset($aday->student_number)) {{$aday->grade_avg}}@endif" type="text" class="form-control" id="student_number"
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
                                            <input value='{{$aday->h_school_name}}' type="text" class="form-control" id="h_school_name"
                                                   placeholder="Okul adınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="h_school_city">Okulun Bulunduğu Şehir</label>
                                            <select onchange="getDistricts(this,'h_school_district')" id="h_school_city" class="form-select">
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if(isset($aday->h_school_city ) && $aday->h_school_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="h_school_district">Okulun Bulunduğu İlçe</label>
                                            <select id="h_school_district" class="form-select">
                                                <option>{{$aday->h_school_district}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value=" @if(isset($aday->student_number)) {{$aday->student_number}}@endif"  type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="class">Sınıfınız</label>
                                            <select id="class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option @selected(isset($aday->class) && $aday->class == '9')  value="9">9</option>
                                                <option @selected(isset($aday->class) && $aday->class == '10')  value="10">10</option>
                                                <option @selected(isset($aday->class) && $aday->class == '11')  value="11">11</option>
                                                <option @selected(isset($aday->class) && $aday->class == '12')  value="12">12</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="is_transfered">Nakil Yaptı mı?</label>
                                            <select id="is_transfered" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Evet') value="Evet">Evet</option>
                                                <option  @selected(isset($aday->is_transfered) && $aday->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="averageGrade">Not Ortalaması</label>
                                            <input @if(isset($aday->grade_avg)) value="{{$aday->grade_avg}}" @endif  type="text" class="form-control" id="averageGrade"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    @break
                                @case('onlisans')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_high_school">Bitirdiğiniz Lise</label>
                                            <input @if(isset($aday->grade_high_school)) value="{{$aday->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                                                   placeholder="Lise bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                                            <input @if(isset($aday->entry_grade_university)) value="{{$aday->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                                                   placeholder="Puanınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_city">Okulun Bulunduğu Şehir</label>
                                            <select id="university_city" class="form-select">
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                                            <select id="current_university" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                @foreach($unis as $u)
                                                    <option data-id='{{$u->id}}' @selected(isset($aday->current_university) && $aday->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                                            <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                                                <option>Fakulte Seciniz</option>
                                                @if($aday->university_faculty)
                                                    <option selected value="{{$aday->university_faculty}}">{{$aday->university_faculty}}</option>
                                                @endif
                                                </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                                            <select data-dataset="" class="form-select" name="grade_departmant" required="" id="grade_departmant">
                                                <option>Bölüm Seciniz</option>
                                                @if($aday->grade_departmant)
                                                    <option selected value="{{$aday->grade_departmant}}">{{$aday->grade_departmant}}</option>
                                                @endif
                                                </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_type">Üniversitenin Statüsü</label>
                                            <select id="university_type" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->university_type) && $aday->university_type == 'Devlet') value="Devlet">Devlet</option>
                                                <option @selected(isset($aday->university_type) && $aday->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_types"> Öğrenim Türü</label>
                                            <select id="university_types" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'Örgün') value="Örgün">Örgün</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="university_class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '1') value="1">1.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '2') value="2">2.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '3') value="3">3.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '4') value="4">4.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '5') value="5">5.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '6') value="6">6.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                            <select id="university_educ_time" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '2') value="2">2</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '3') value="3">3</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '5') value="5">5</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '7') value="7">7</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '4') value="4">4</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '6') value="6">6</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value='@if(isset($aday->student_number)) {{$aday->student_number}} @endif'  type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agnoSystem">AGNO Sisteminiz</label>
                                            <select id="agnoSystem" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno">AGNO</label>
                                            <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="university_transfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                                                <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                bilgilerinizi yazınız</label>
                                            <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                   placeholder="Geçiş bilgilerinizi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 form-group">
                                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                                yazınız</label>
                                            <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages">
                                        </div>
                                    </div>

                                    @break
                                @case('lisans')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_high_school">Bitirdiğiniz Lise</label>
                                            <input @if(isset($aday->grade_high_school)) value="{{$aday->grade_high_school}}"  @endif type="text" class="form-control" id="grade_high_school"
                                                   placeholder="Lise bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="entry_grade_university">Üniversiteye Giriş Puanınız</label>
                                            <input @if(isset($aday->entry_grade_university)) value="{{$aday->entry_grade_university}}"  @endif type="text" class="form-control" id="entry_grade_university"
                                                   placeholder="Puanınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_city">Okulun Bulunduğu Şehir</label>
                                            <select id="university_city" class="form-select">
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="current_university">Öğrenime Devam Ettiğiniz Üniversite</label>
                                            <select id="current_university" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                @foreach($unis as $u)
                                                    <option data-id='{{$u->id}}' @selected(isset($aday->current_university) && $aday->current_university == $u->name) value="{{$u->name}}">{{$u->name}}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_faculty">Öğrenime Devam Ettiğiniz Fakülte</label>
                                            <select data-dataset="" class="form-select" name="university_faculty" required="" id="university_faculty">
                                                <option>Fakulte Seciniz</option>
                                                @if($aday->university_faculty)
                                                    <option selected value="{{$aday->university_faculty}}">{{$aday->university_faculty}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_departmant">Öğrenime Devam Ettiğiniz Bölüm</label>
                                            <select data-dataset="" class="form-select" name="grade_departmant" required="" id="grade_departmant">
                                                <option>Bölüm Seciniz</option>
                                                @if($aday->grade_departmant)
                                                    <option selected value="{{$aday->grade_departmant}}">{{$aday->grade_departmant}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_type">Üniversitenin Statüsü</label>
                                            <select id="university_type" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->university_type) && $aday->university_type == 'Devlet') value="Devlet">Devlet</option>
                                                <option @selected(isset($aday->university_type) && $aday->university_type == 'Vakıf/Özel') value="Vakıf/Özel">Vakıf/Özel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_types"> Öğrenim Türü</label>
                                            <select id="university_types" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'Örgün') value="Örgün">Örgün</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'İkinci Öğretim') value="İkinci Öğretim">İkinci Öğretim</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'Uzaktan') value="Uzaktan">Uzaktan</option>
                                                <option @selected(isset($aday->university_types) && $aday->university_types == 'Açık Öğretim') value="Açık Öğretim">Açık Öğretim</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="educationYear">{{$period->title}} Öğretim Yılında Kaçıncı Sınıfta
                                                Olacaksınız?</label>
                                            <select id="university_class" class="form-select">
                                                <option selected disabled value="">Seçiniz...</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '1') value="1">1.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '2') value="2">2.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '3') value="3">3.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '4') value="4">4.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '5') value="5">5.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == '6') value="6">6.Sınıf</option>
                                                <option @selected(isset($aday->university_class) && $aday->university_class == 'Hazırlık') value="Hazırlık">Hazırlık</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_educ_time">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                            <select id="university_educ_time" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '2') value="2">2</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '3') value="3">3</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '4') value="4">4</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '5') value="5">5</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '6') value="6">6</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '7') value="7">7</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input value='@if(isset($aday->student_number)) {{$aday->student_number}} @endif'  type="text" class="form-control" id="student_number"
                                                   placeholder="Öğrenci numaranızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agnoSystem">AGNO Sisteminiz</label>
                                            <select id="agnoSystem" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno">AGNO</label>
                                            <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="university_transfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                                                <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                bilgilerinizi yazınız</label>
                                            <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                   placeholder="Geçiş bilgilerinizi giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3 form-group">
                                            <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                                yazınız</label>
                                            <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages">
                                        </div>
                                    </div>

                                    @break
                                @case('yukseklisans')
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_university">Bitirdiğiniz Üniversite</label>
                                            <input  @if(isset($aday->grade_university)) value="{{$aday->grade_university}}" @endif type="text" class="form-control" id="grade_university"
                                                    placeholder="Üniversite bilgisi giriniz...">
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_departmant">Mezun Olduğunuz Bölüm</label>
                                            <input type="text" @if(isset($aday->grade_departmant)) value="{{$aday->grade_departmant}}" @endif class="form-control" id="grade_departmant"
                                                   placeholder="Puanınızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_city">Üniversitenin Bulunduğu Şehir</label>
                                            <select id="university_city" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                @foreach($cities as $city)
                                                    <option data-id="{{ $city->id }}"  @if( isset($aday->university_city) && $aday->university_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
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
                                            <input @if(isset($aday->master_field)) value="{{$aday->master_field}}" @endif type="text" class="form-control" id="master_field"
                                                   placeholder="Dal bilgisi giriniz...">
                                        </div>

                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="student_number">Öğrenci Numarası</label>
                                            <input @if(isset($aday->student_number)) value="{{$aday->student_number}}" @endif  type="text" class="form-control" id="student_number"
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
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '2') value="2">2</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '3') value="3">3</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '4') value="4">4</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '5') value="5">5</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '6') value="6">6</option>
                                                <option @selected(isset($aday->departmentYear) && $aday->departmentYear == '7') value="7">7</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="grade_agno">Mezuniyet AGNO</label>
                                            <input  @if(isset($aday->grade_agno)) value="{{$aday->grade_agno}}" @endif type="text" class="form-control" id="grade_agno"
                                                    placeholder="Agno giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno_type">AGNO Sisteminiz</label>
                                            <select id="agno_type" class="form-select">
                                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "4'lük") value="4'lük">4'lük</option>
                                                <option @selected(isset($aday->agno_type) && $aday->agno_type == "100'lük") value="100'lük">100'lük</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="agno">AGNO</label>
                                            <input value="@if(isset($aday->agno)) {{$aday->agno}} @endif" type="text" class="form-control" id="agno"
                                                   placeholder="Not ortalamanızı giriniz...">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer">Yatay/Dikey Geçiş Yaptı mı?</label>
                                            <select id="university_transfer" class="form-select">
                                                <option value="">Seçiniz...</option>
                                                <option value="Evet" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Evet')>Evet</option>
                                                <option value="Hayır" @selected(isset($aday->university_transfer) && $aday->university_transfer == 'Hayır')>Hayır</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3 form-group">
                                            <label for="university_transfer_desc">Yatay/Dikey Geçiş yaptıysanız geçiş
                                                bilgilerinizi yazınız</label>
                                            <input value="@if(isset($aday->university_transfer_desc)) {{$aday->university_transfer_desc}} @endif" type="text" class="form-control" id="university_transfer_desc"
                                                   placeholder="Geçiş bilgilerinizi giriniz...">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 form-group">
                                        <label for="languages">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte
                                            yazınız</label>
                                        <input value="@if(isset($aday->languages)) {{$aday->languages}} @endif" type="text" class="form-control" id="languages"
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
                                <p>{{$aday->housing_type}}</p>

                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Ödenen Ücret</label>
                                <input id="housing_fee" type="text" class="form-control" value="{{$aday->housing_fee}}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Birlikte Yaşanılan Kişi Sayısı</label>
                                <p>{{$aday->living_with_count}}</p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Kaldığı İl</label>
                                <p>{{$aday->residing_city}}</p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Kaldığı İlçe</label>
                                <p>{{$aday->residing_district}}</p>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="custom-label">Tam Adres</label>
                                <p>{{$aday->address_detail}}</p>
                            </div>
                           </div>

                           <hr>
                           <!--  Aile Adresi Bilgileri -->
                           <h3>Aile Adres Bilgileri</h3>
                           <div class="row">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Yaşadığı İl</label>
                                    <p>{{$aday->mother_city}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Yaşadığı İl</label>
                                    <p>{{$aday->father_city}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Yaşadığı İlçe</label>
                                    <p>{{$aday->mother_district}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Yaşadığı İlçe</label>
                                    <p>{{$aday->father_district}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Açık Adres</label>
                                    <p>{{$aday->parent_address}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label" for="phone">Aile Cep Telefonu</label>
                                    <p>{{$aday->parent_mobile}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aile Ev Telefonu</label>
                                    <p>{{$aday->parent_phone}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aile E-posta Adresi</label>
                                    <p>{{$aday->parent_email}}</p>
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
                                        <p>{{$aday->emergency_person_name}}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Soyad</label>
                                        <p>{{$aday->emergency_person_surname}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Yakınlık Derecesi</label>
                                        <p>{{$aday->emergency_closeness}}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Cep Telefonu</label>
                                        <p>{{$aday->emergency_mobile}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">E-Posta Adresi</label>
                                        <p>{{$aday->emergency_email ?? 'Belirtilmemiş'}}</p>
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
                                    <p>{{$aday->parent_together}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Anne Sağ Mı?</label>
                                    <p>{{$aday->mother_alive}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Baba Sağ Mı?</label>
                                    <p>{{$aday->C9l7SUqOxSvZ}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Anne Ad </label>
                                    <p>{{$aday->mother_name}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Anne Soyad</label>
                                    <p>{{$aday->mother_surname}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Baba Ad</label>
                                    <p>{{$aday->father_name}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Baba Soyad</label>
                                    <p>{{$aday->father_surname}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Mesleği</label>
                                    <p>{{$aday->mother_job}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Mesleği</label>
                                    <p>{{$aday->father_job}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Tahsil Durumu</label>
                                    <p>{{$aday->mother_educ}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Tahsil Durumu</label>
                                    <p>{{$aday->father_educ}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Bağlı Olduğu Sosyal Güvenlik
                                        Kurumu</label>
                                    <p>{{$aday->mother_company}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                                        Kurumu</label>
                                    <p>{{$aday->father_company}}</p>
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
                                    <p>{{$aday->count}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kendisi Dahil Okuyan Kardeş Sayısı</label>
                                    <p>{{$aday->educ_count}}</p>
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
                                @foreach($aday->kardesler as $kardes)
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
                                    <p>{{$aday->income_person}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç
                                        Kişiye
                                        Bakıyor?</label>
                                    <p>{{$aday->total_person}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                                    <p>{{$aday->mother_salary}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                                    <p>{{$aday->father_salary}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Diğer Kişilerin Aylık Net Geliri
                                        (TL)</label>
                                    <p>{{$aday->other_salary}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Başka Geliri Var Mı?</label>
                                    <p>{{$aday->other_income}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                                    <p>{{$aday->parent_housing_type}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                                    <p>{{$aday->rent_count}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Diğer</label>
                                    <p>{{$aday->other_detail}}</p>
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
                                    <p>{{$aday->government}}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Özel Burs Almakta ya da Başvurdu mu?</label>
                                    <p>{{$aday->special}}</p>
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
                                @foreach($aday->scholars as $sc)
                                    <tr>
                                        <td></td>
                                        <td>{{$sc->company_name}}</td>
                                        <td>{{$sc->company_type}}</td>
                                        <td>{{$sc->count}}</td>

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
                                    <p>{{$aday->disabled_status}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Engel Durumunu Açıklayınız (Varsa)</label>
                                    <p>{{$aday->disabled_detail}}</p>
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
                                        <p>{{$aday->platform}}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Güçlü Yanlarınızın Ne olduğunu
                                            Düşünüyorsunuz?</label>
                                        <p>{{$aday->skills}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Katkıda Bulunduğunuz Sosyal Projeler</label>
                                        <p>{{$aday->social_projects}}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Hobileriniz</label>
                                        <p>{{$aday->hobbies}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
                                        <p>{{$aday->sports}}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Son Okuduğunuz Kitaplar</label>
                                        <p>{{$aday->last_books}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Bize Mesajınız</label>
                                        <p>{{$aday->message}}</p>
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
                                        <p>{{$aday->bank_name}}</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="iban" class="form-label">IBAN</label>
                                            <p>{{$aday->iban}}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="custom-label">Hesap Numarası</label>
                                            <p>{{$aday->account_number}}</p>
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
                                        <p>{{$aday->is_working}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Kurum Adı</label>
                                        <p>{{$aday->job_company}}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Görev</label>
                                        <p>{{$aday->job_rank}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Sosyal Güvenlik Kurumu</label>
                                        <p>{{$aday->job_sgk}}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Aylık Net Ücret (TL)</label>
                                        <p>{{$aday->job_salary}}</p>
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

<div class="tab-pane fade" id="sibling-info" role="tabpanel"
     aria-labelledby="sibling-info-tab" data-content="7">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="kardesSayi" class="form-label">Kardeş Sayısı</label>
            <input value="@if(isset($aday->sibling->count)) {{$aday->sibling->count}} @endif" type="text" class="form-control" id="kardesSayi" placeholder="Kardeş sayısı giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="okuyanKardes" class="form-label">Kendisi Dahil Okuyan Kardeş Sayısı</label>
            <input value="@if(isset($aday->sibling->educ_count)) {{$aday->sibling->educ_count}} @endif" type="text" class="form-control" id="okuyanKardes" placeholder="Okuyan kardeş sayısını giriniz...">
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button id="addButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#kardesEkleModal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M9.16797 9.1665V4.1665H10.8346V9.1665H15.8346V10.8332H10.8346V15.8332H9.16797V10.8332H4.16797V9.1665H9.16797Z" fill="#4069E5"/>
            </svg> Kardeş Ekle</button>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Adı</th>
            <th>Soyadı</th>
            <th>Yaşı</th>
            <th>Öğrenim Durumu</th>
            <th>Medeni Durumu</th>
            <th>Mesleği (Çalışıyorsa)</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody id="siblingsTableBody">
        </tbody>
    </table>
</div>

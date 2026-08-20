<div class="tab-pane fade" id="other-info" role="tabpanel"
     aria-labelledby="other-info-tab" data-content="9">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="devletBurs">Devlet Bursu Alıyor musunuz veya Aktif Başvurunuz Var mı?</label>
            <select id="devletBurs" class="form-select">
                <option disabled selected value="">Seçiniz...</option>
                <option @selected(isset($aday->scholar->government) && $aday->scholar->government == 'Evet') value="Evet">Evet</option>
                <option @selected(isset($aday->scholar->government) && $aday->scholar->government == 'Hayır') value="Hayır">Hayır</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="ozelBurs">Özel Burs Alıyor musunuz veya Aktif Başvurunuz Var mı?</label>
            <select id="ozelBurs" class="form-select">
                <option disabled selected value="">Seçiniz...</option>
                <option @selected(isset($aday->scholar->special) && $aday->scholar->special == 'Evet') value="Evet">Evet</option>
                <option @selected(isset($aday->scholar->special) && $aday->scholar->special == 'Hayır') value="Hayır">Hayır</option>
            </select>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button id="addButton" type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                data-bs-target="#bursEkleModal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M9.16797 9.1665V4.1665H10.8346V9.1665H15.8346V10.8332H10.8346V15.8332H9.16797V10.8332H4.16797V9.1665H9.16797Z" fill="#4069E5"/>
            </svg> Burs Ekle</button>
    </div>
    <table class="table table-striped">
        <thead>

        <tr>
            <th>#</th>
            <th>Burs</th>
            <th>Kurum Türü</th>
            <th>Kurum Adı</th>
            <th> Burs Tutarı</th>
        </tr>
        </thead>
        <tbody id="bursTableBody">
        @php $sayac = 0; @endphp
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">Toplam</td>
            <td><span id="scholar_count">{{$sayac}}</span></td>
        </tr>
        </tfoot>
    </table>
</div>

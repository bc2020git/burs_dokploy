<div class="tab-pane fade show active" id="general-info" role="tabpanel"
     aria-labelledby="general-info-tab" data-content="1">
    <div class="tab-section">
        <input type="hidden" id="adayId" name="adayId" value="{{$aday->scholar->id}}">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Adı</label>
                <input id="name" type="text" class="form-control" value="{{$aday->scholar->name}}" >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Soyadı</label>
                <input id="surname" type="text" class="form-control" value="{{$aday->scholar->surname}}" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">TC Kimlik Numarası</label>
                <input name="tc_no" id="tc_no" type="text" class="form-control" value="{{$aday->infos->tc_no}}" >
            </div>
            <div class="col-md-6 form-group">
                <label for="email" class="custom-label">E-Posta</label>
                <input type="text" id="email" class="form-control" value="{{$aday->scholar->email}}">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6 form-group d-flex flex-column">
                <label class="custom-label">Telefon</label>
                <input id="tel_no" type="text" class="form-control telinputs"
                       value="{{$aday->infos->tel_no}}">
            </div>
            <div class="col-md-6 d-none form-group">
                <label class="custom-label">Şube</label>
                <input  id="sube" type="text" class="form-control" value=" {{$aday->infos->sube}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Bursiyer Tipi</label>
                <select id="aday_turu" class="form-select">
                    <option value="">Seçiniz</option>
                    <option @if($aday->infos->aday_turu == 'Dernek') selected @endif value="Dernek">Dernek</option>
                    <option @if($aday->infos->aday_turu == 'Vakıf') selected @endif value="Vakıf">Vakıf</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Burs Tipi</label>
                <select id="burs_tipi_id" class="form-select">
                    <option value="">Seçiniz</option>
                    @foreach(($bursTipleri ?? []) as $tip)
                        <option value="{{ $tip->id }}" @selected($aday->infos->burs_tipi_id == $tip->id)>{{ $tip->burs_tipi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-check">
                <input  class="form-check-input" type="checkbox" id="check_taahhutname" @if($aday->infos->check_taahhutname == 'on') checked @endif>
                <p class="form-check-label mt-1" for="confirmation1"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>Taahhütname'yi</u> okudum, kabul ediyorum
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" @if($aday->infos->check_ailebireyleri == 'on') checked @endif type="checkbox" id="check_ailebireyleri">
                <p class="form-check-label mt-1 " for="check_ailebireyleri"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum, anladım.
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" @if($aday->infos->check_aydinlatma == 'on') checked @endif type="checkbox" id="check_aydinlatma">
                <p class="form-check-label mt-1 " for="check_aydinlatma"
                   style="cursor: pointer;"
                   onclick="window.location.href='https://sacdd.org.tr/index.php/burs-fonu/kvkk';">
                    <u> Bursiyer Aydınlatma Metni'ni okudum, anladım. .</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" @if($aday->infos->check_acikriza == 'on') checked @endif type="checkbox" id="check_acikriza">
                <p class="form-check-label mt-1 " for="confirmation4"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" @if($aday->infos->check_ailerizaformu == 'on') checked @endif type="checkbox" id="check_ailerizaformu">
                <p class="form-check-label mt-1 " for="check_ailerizaformu"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>Bursiyer Aile Bireyleri Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" @if($aday->infos->check_bilgidogrulama == 'on') checked @endif type="checkbox" id="check_bilgidogrulama">
                <p class="form-check-label mt-1 " for="check_bilgidogrulama">
                    Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve
                    gerektiğinde
                    araştırma yapılmasını kabul ediyorum.
                </p>
            </div>
        </div>

    </div>
</div>

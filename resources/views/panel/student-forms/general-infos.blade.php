<div class="tab-pane fade show active" id="general-info" role="tabpanel" aria-labelledby="general-info-tab"
    data-content="1">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Adı</label>
                <input type="hidden" name="period_id" id="period_id" value="{{$aday->period_id}}">
                <input id="name" type="text" class="form-control" value="{{$aday->name}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Soyadı</label>
                <input id="surname" type="text" class="form-control" value="{{$aday->surname}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">TC Kimlik Numarası</label>
                <input id="tc_no" type="text" class="form-control" value="{{$aday->tc_no}}" maxlength="11">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">E-Posta</label>
                <input id="email" name="email" type="text" class="form-control" value="{{$aday->email}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label d-block">Telefon</label>
                <input id="tel_no" type="text" class=" telinputs form-control" value="{{$aday->tel_no}}">
            </div>
            <div class="col-md-6 d-none form-group">
                <label class="custom-label">Şube</label>
                <input id="sube" type="text" class="form-control" value=" {{$aday->sube}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Bursiyer Tipi</label>
                <select id="aday_turu" class="form-select">
                    <option value="">Seçiniz</option>
                    <option @if($aday->aday_turu == 'Dernek') selected @endif value="Dernek">Dernek</option>
                    <option @if($aday->aday_turu == 'Vakıf') selected @endif value="Vakıf">Vakıf</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Burs Tipi</label>
                <select id="burs_tipi_id" class="form-select">
                    <option value="">Seçiniz</option>
                    @foreach(($bursTipleri ?? []) as $tip)
                        <option value="{{ $tip->id }}" @selected($aday->burs_tipi_id == $tip->id)>{{ $tip->burs_tipi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Aday Dönemi</label>
                <select id="period_id" class="form-select">
                    <option value="">Seçiniz</option>
                    @foreach(($periodlar ?? []) as $pOption)
                        <option value="{{ $pOption->id }}" @selected(($aday->period_id == $pOption->id) || ($aday->period_id && isset($period) && $period->title == $pOption->title))>{{ $pOption->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" id="check_taahhutname"
                    @if($aday->check_taahhutname == 'on') checked @endif>
                <p class="form-check-label mt-1" for="check_taahhutname" data-bs-toggle="modal"
                    data-bs-target="#kvkkModal">
                    <u>Taahhütname'yi</u> okudum, kabul ediyorum
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" id="check_ailebireyleri"
                    @if($aday->check_ailebireyleri == 'on') checked @endif>
                <p class="form-check-label mt-1 " for="check_ailebireyleri" data-bs-toggle="modal"
                    data-bs-target="#kvkkModal">
                    <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum, anladım.
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" id="check_aydinlatma" @if($aday->check_aydinlatma == 'on')
                checked @endif>
                <p class="form-check-label mt-1 " for="check_aydinlatma" style="cursor: pointer;"
                    onclick="window.location.href='https://sacdd.org.tr/index.php/burs-fonu/kvkk';">
                    <u>Bursiyer Aydınlatma Metni'ni okudum, anladım..</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" id="check_acikriza" @if($aday->check_acikriza == 'on')
                checked @endif>
                <p class="form-check-label mt-1 " for="check_acikriza" data-bs-toggle="modal"
                    data-bs-target="#kvkkModal">
                    <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" id="check_ailerizaformu"
                    @if($aday->check_ailerizaformu == 'on') checked @endif>
                <p class="form-check-label mt-1 " for="check_ailerizaformu" data-bs-toggle="modal"
                    data-bs-target="#kvkkModal">
                    <u>Bursiyer Aile Bireyleri Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" id="check_bilgidogrulama"
                    @if($aday->check_bilgidogrulama == 'on') checked @endif>
                <p class="form-check-label mt-1 " for="check_bilgidogrulama">
                    Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve
                    gerektiğinde
                    araştırma yapılmasını kabul ediyorum.
                </p>
            </div>
        </div>
    </div>
</div>
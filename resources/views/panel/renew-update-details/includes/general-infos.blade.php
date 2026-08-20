<div class="tab-pane fade show active" id="general-info" role="tabpanel"
     aria-labelledby="general-info-tab" data-content="1">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Adı</label>
                <input type="hidden" name="period_id" id="period_id" value="{{$aday->period_id}}">
                <input id="name" type="text" class="form-control" value="{{$aday->name}}" >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Soyadı</label>
                <input id="surname" type="text" class="form-control" value="{{$aday->surname}}" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">TC Kimlik Numarası</label>
                <input id="tc_no" type="text" class="form-control" value="{{$aday->tc_no}}" >
            </div>
            <div class="col-md-6 form-group">
                <label id="email" class="custom-label">E-Posta</label>
                <input type="text" class="form-control" value="{{$aday->email}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Telefon</label>
                <input id="tel_no" type="text" class="form-control telinputs"
                       value="{{$aday->tel_no}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Şube</label>
                <input id="sube" type="text" class="form-control" value=" {{$aday->sube}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" @if($aday->check_taahhutname == 'on') checked @endif id="check_taahhutname">
                <p class="form-check-label mt-1" for="check_taahhutname"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>Taahhütname'yi</u> okudum, kabul ediyorum
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" @if($aday->check_ailebireyleri == 'on') checked @endif id="check_ailebireyleri">
                <p class="form-check-label mt-1 " for="check_ailebireyleri"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum, anladım.
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" @if($aday->check_acikriza == 'on') checked @endif id="check_acikriza">
                <p class="form-check-label mt-1 " for="check_acikriza"
                   style="cursor: pointer;"
                   onclick="window.location.href='https://sacdd.org.tr/index.php/burs-fonu/kvkk';">
                    <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" @if($aday->check_acikriza == 'on') checked @endif id="check_acikriza">
                <p class="form-check-label mt-1 " for="check_acikriza"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" @if($aday->check_aydinlatma == 'on') checked @endif id="check_aydinlatma">
                <p class="form-check-label mt-1 " for="check_aydinlatma"
                   data-bs-toggle="modal" data-bs-target="#kvkkModal">
                    <u>KVKK Kurallarının gereksinimlerini kabul ederim.</u>
                </p>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="checkbox" @if($aday->check_bilgidogrulama == 'on') checked @endif id="check_bilgidogrulama">
                <p class="form-check-label mt-1 " for="check_bilgidogrulama">
                    Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve
                    gerektiğinde
                    araştırma yapılmasını kabul ediyorum.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="step-content active" id="step-1" data-content="1">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="bursiyerAdi" class="form-label">Adı</label>
            <input type="text" class="form-control" id="bursiyerAdi" value="{{ Auth::guard('aday')->user()->name }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
            <input type="text" class="form-control" id="bursiyerSoyadi" value="{{ Auth::guard('aday')->user()->surname }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
            <input type="text" class="form-control" id="bursiyerTcNo" value="{{ Auth::guard('aday')->user()->tc_no }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label for="bursiyerPosta" class="form-label">E-posta</label>
            <input type="email" class="form-control" id="bursiyerPosta" value="{{ Auth::guard('aday')->user()->email }}"
                   readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="bursiyerSube" class="form-label">Şube</label>
            <input type="text" class="form-control" id="bursiyerSube"
                   value="Şube ataması sistem tarafından yapılacaktır." readonly>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-6'>    
        <div class="form-check">
        <input @if(isset($aday->confirmInfos) && $aday->confirmInfos == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation1">
            <p class="form-check-label mt-1 " for="confirmation1" data-bs-toggle="modal" data-bs-target="#taahutnamemodal">
            <u>Taahhütname'yi okudum, kabul ediyorum.</u>
        </p>
    </div>
    </div>
        <div class='col-md-6'>    <div class="form-check">
        <input @if(isset($aday->confirmKvkk) && $aday->confirmKvkk == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation2">
            <a target='_blank' href='https://sacdd.org.tr/index.php/burs-fonu/kvkk'>Bursiyer Aile Bireyleri Aydınlatma Metni</a>'ni okudum, anladım.
    </div>
    </div>


        <div class='col-md-6'>    <div class="form-check">
        <input @if(isset($aday->confirmKvkk) && $aday->confirmKvkk == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation2">
            <a target='_blank' href='https://sacdd.org.tr/index.php/burs-fonu/kvkk'>Bursiyer Aydınlatma Metni</a>'ni okudum, anladım.
    </div>
    </div>

                 <div class='col-md-6'><div class="form-check">
        <input @if(isset($aday->confirmKvkk) && $aday->confirmKvkk == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation2">
        <p class="form-check-label mt-1 " for="confirmation2" data-bs-toggle="modal" data-bs-target="#bursiyerailebireyleririzamodal">
            <u>Bursiyer Aile Bireyleri  Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
        </p>
    </div>
    </div>
         <div class='col-md-6'>    <div class="form-check">
        <input @if(isset($aday->confirmKvkk) && $aday->confirmKvkk == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation2">
        <p class="form-check-label mt-1 " for="confirmation2" data-bs-toggle="modal" data-bs-target="#bursiyeracikrizamodal">
            <u>Bursiyer  Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
        </p>
    </div>
    </div>
    
   
        <div class='col-md-6'>    <div class="form-check">
        <input @if(isset($aday->confirmKvkk) && $aday->confirmKvkk == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation2">
            <u>Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve gerektiğinde araştırma yapılmasını kabul ediyorum.</u>
    </div></div>
    </div>




</div>

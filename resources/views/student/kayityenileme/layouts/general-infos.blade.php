<div class="step-content active" id="step-1" data-content="1">
    <div class="row">
        <div class="col-md-6 mb-3">
            <input type="hidden" name="form_id" value="{{$aday->id}}">

            <label for="bursiyerAdi" class="form-label">Adı</label>
            <input type="text" class="form-control" id="bursiyerAdi" value="{{$aday->scholar->name}}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label for="bursiyerSoyadi" class="form-label">Soyadı</label>
            <input type="text" class="form-control" id="bursiyerSoyadi" value="{{$aday->scholar->surname }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="bursiyerTcNo" class="form-label">TC Kimlik Numarası</label>
            <input type="text" class="form-control" id="bursiyerTcNo" value="{{ $aday->scholar->tc_no }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label for="bursiyerPosta" class="form-label">E-posta</label>
            <input type="email" class="form-control" id="bursiyerPosta" value="{{ $aday->scholar->email }}"
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
    <div class="form-check">
        <input @if(isset($aday->confirmInfos) && $aday->confirmInfos == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation1">
        <p class="form-check-label mt-1" for="confirmation1">
            Vermiş olduğum cevapların doğru olduğunu kabul ve taahhüt ederim.
        </p>
    </div>
    <div class="form-check">
        <input @if(isset($aday->confirmKvkk) && $aday->confirmKvkk == 'Evet') checked @endif class="form-check-input" type="checkbox" id="confirmation2">
        <p class="form-check-label mt-1 " for="confirmation2" data-bs-toggle="modal" data-bs-target="#kvkkModal">
            <u>KVKK Kurallarının gereksinimlerini kabul ederim.</u>
        </p>
    </div>
</div>

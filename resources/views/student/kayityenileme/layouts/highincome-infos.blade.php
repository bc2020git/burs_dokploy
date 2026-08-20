<div class="row">
    <div class="col-md-12 mb-3">
        <label for="krediborcu" class="form-label">Kredi borcu ödüyor musunuz? Ödüyorsanız tutarı ile birikte yazınız</label>
        <input value="@if(isset($aday->income->cc_payment)) {{$aday->income->cc_payment}} @endif" type="text" class="form-control" id="krediborcu"
               placeholder="Kişi bilgisi giriniz...">
    </div>
    <div class="col-md-12 mb-3">
        <label for="calısılanIs" class="form-label">Herhangi bir işte çalışıyor musunuz? Evet ise çalışma şekliniz ve aylık gelirinizi belirtiniz</label>
        <input value="@if(isset($aday->income->job_details)) {{$aday->income->job_details}} @endif" type="text" class="form-control" id="calısılanIs"
               placeholder="Gelir bilgisi giriniz...">
    </div>            <input type="hidden" name="form_id" value="{{$aday->id}}">

</div>

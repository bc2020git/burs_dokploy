<div class="step-content" id="step-12" data-content="12">
    <input type="hidden" class="form-control" id="tc_no" value="{{ Auth::guard('aday')->user()->tc_no }}">

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="bank-name">Banka Adı</label>
            <select id="employment-status" class="form-select">
                <option value="" disabled >Seçiniz...</option>
                <option  @selected(isset($aday->bank->bank_name) && $aday->bank->bank_name == 'Vakıfbank') value="Vakıfbank">Vakıfbank</option>
                <option  @selected(isset($aday->bank->bank_name) && $aday->bank->bank_name == 'Ziraat Bankası') value="Ziraat Bankası">Ziraat Bankası</option>
                <option  @selected(isset($aday->bank->bank_name) && $aday->bank->bank_name == 'İş bankası') value="İş bankası">İş bankası</option>
                <option  @selected(isset($aday->bank->bank_name) && $aday->bank->bank_name == 'FinansBank') value="FinansBank">FinansBank</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="iban" class="form-label">IBAN</label>
            <input value="@if(isset($aday->bank->iban)) {{$aday->bank->iban}} @endif"  type="text" class="form-control" id="iban" placeholder="IBAN giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="hesapNumarasi" class="form-label">Hesap Numarası</label>
            <input value="@if(isset($aday->bank->account_number)) {{$aday->bank->account_number}} @endif" type="text" class="form-control" id="hesapNumarasi"
                   placeholder="Hesap numarası giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <p class="text-muted">! Banka hesabı öğrenci adına açılmış olmalıdır.</p>
        </div>
    </div>
</div>

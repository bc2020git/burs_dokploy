<div class="tab-pane fade" id="account-info" role="tabpanel"
     aria-labelledby="account-info-tab" data-content="12">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Banka</label>
                <select id="bank_name" class="form-select">
                    <option selected disabled>Seçiniz...</option>
                    @foreach($bankNames as $bank)
                        <option @if($aday->infos->bank_name == $bank) selected @endif value="{{$bank}}">{{$bank}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Banka Kodu</label>
                <input id="" type="text" class="form-control" >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Şube</label>
                <input id="" type="text" class="form-control" value="">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Şube Kodu</label>
                <input id="" type="text" class="form-control" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">IBAN</label>
                <input id="iban" type="text" class="form-control" @if(isset($aday->infos->iban)) value="{{$aday->infos->iban}}" @endif >
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Hesap Numarası</label>
                <input id="account_number" type="text" class="form-control" @if(isset($aday->infos->account_number)) value="{{$aday->infos->account_number}}" @endif >
            </div>
        </div>
    </div>
</div>

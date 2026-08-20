
<div class="tab-pane fade" id="account-info" role="tabpanel"
     aria-labelledby="account-info-tab" data-content="12">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Banka</label>
                <select id="bank_name" class="form-select">
                    <option selected disabled>Seçiniz...</option>
                    @foreach($bankNames as $bank)
                        <option @if($aday->bank_name == $bank) selected @endif value="{{$bank}}">{{$bank}}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="iban" class="form-label">IBAN</label>
                    <input type="text" class="form-control" id="iban"
                           value="{{$aday->iban}}" maxlength="26">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label class="custom-label">Hesap Numarası</label>
                    <input id="account_number" type="text" class="form-control"
                           value="{{$aday->account_number}}">
                </div>
            </div>
        </div>
    </div>
</div>

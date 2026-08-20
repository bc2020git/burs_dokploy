<div class="step-content" id="step-10" data-content="10">
    <input type="hidden" id="form_id" name="form_id" value="{{$aday->id}}">

    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="engelDurumu" class="form-label">Herhangi bir engel durumunuz var mı?</label>
            <select class="form-select" id="engelDurumu" required>
                <option selected disabled>Seçiniz...</option>
                <option @selected(isset($aday->disabled->status) && $aday->disabled->status == 'Evet') value="Evet">Evet</option>
                <option @selected(isset($aday->disabled->status) && $aday->disabled->status == 'Hayır') value="Hayır">Hayır</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="engelAciklama" class="form-label">Engel durumunu açıklayınız (varsa)</label>
            <input value="@if(isset($aday->disabled->detail)){{$aday->disabled->detail}} @endif" type="text" class="form-control" id="engelAciklama"
                   placeholder="Açıklama giriniz...">
        </div>
    </div>
</div>

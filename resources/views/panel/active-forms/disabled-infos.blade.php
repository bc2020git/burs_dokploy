<div class="tab-pane fade" id="disabled-info" role="tabpanel"
     aria-labelledby="disabled-info-tab" data-content="10">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Herhangi Bir Engeliniz Var mı?</label>
                <select id="disabled_status" class="form-select">
                    <option @if($aday->infos->disabled_status == 'Evet') selected @endif  value="Evet">Evet</option>
                    <option @if($aday->infos->disabled_status == 'Hayır') selected @endif value="Hayır">Hayır</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Engel Durumunu Açıklayınız (Varsa)</label>
                <input id="disabled_detail" type="text" class="form-control" @if(isset($aday->infos->disabled_detail))  value="{{$aday->infos->disabled_detail}}" @endif  >
            </div>
        </div>
    </div>
</div>

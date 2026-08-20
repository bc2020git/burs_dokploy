
<div class="tab-pane fade" id="job-info" role="tabpanel" aria-labelledby="job-info-tab"
     data-content="13">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Düzenli olarak bir kurumda kazanç sağlıyor
                    mu?</label>
                <select id="is_working" class="form-select">
                    <option value=""  selected>Seçiniz...</option>
                    <option @if($aday->is_working == 'Full-time') selected @endif  value="Full-time">Full-time</option>
                    <option @if($aday->is_working == 'Part-time') selected @endif value="Part-time">Part-time</option>
                    <option @if($aday->is_working == 'Stajyer') selected @endif value="Stajyer">Stajyer</option>
                    <option @if($aday->is_working == 'Hayır') selected @endif value="Hayır">Hayır</option>
                    <option @if($aday->is_working == 'Diğer') selected @endif value="Diğer">Diğer</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Kurum Adı</label>
                <input id="job_company" type="text" class="form-control" value="{{$aday->job_company}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Görev</label>
                <input id="job_rank" type="text" class="form-control" value="{{$aday->job_rank}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Sosyal Güvenlik Kurumu</label>
                <input id="job_sgk" type="text" class="form-control" value="{{$aday->job_sgk}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Aylık Net Ücret (TL)</label>
                <input id="job_salary" type="text" class="form-control" value="{{$aday->job_salary}}">
            </div>
        </div>
    </div>
</div>

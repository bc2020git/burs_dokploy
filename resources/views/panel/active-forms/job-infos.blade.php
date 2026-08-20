<div class="tab-pane fade" id="job-info" role="tabpanel" aria-labelledby="job-info-tab"
     data-content="13">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Düzenli olarak bir kurumda kazanç sağlıyor
                    mu?</label>
                <select id="is_working" class="form-select">
                    <option value="" disabled selected>Seçiniz...</option>
                    <option @selected(isset($aday->infos->is_working) && $aday->infos->is_working == 'Full-time') value="Full-time">Full-time</option>
                    <option @selected(isset($aday->infos->is_working) && $aday->infos->is_working == 'Part-time') value="Part-time">Part-time</option>
                    <option @selected(isset($aday->infos->is_working) && $aday->infos->is_working == 'Stajyer') value="Stajyer">Stajyer</option>
                    <option @selected(isset($aday->infos->is_working) && $aday->infos->is_working == 'Hayır') value="Hayır">Hayır</option>
                    <option @selected(isset($aday->infos->is_working) && $aday->infos->is_working == 'Diğer') value="Diğer">Diğer</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Kurum Adı</label>
                <input id="job_company" type="text" class="form-control" @if(isset($aday->infos->job_company)) value="{{$aday->infos->job_company}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Görev</label>
                <input id="job_rank" type="text" class="form-control" @if(isset($aday->infos->job_rank)) value="{{$aday->infos->job_rank}}" @endif >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Sosyal Güvenlik Kurumu</label>
                <input id="job_sgk" type="text" class="form-control" @if(isset($aday->infos->job_sgk)) value="{{$aday->infos->job_sgk}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Aylık Net Ücret (TL)</label>
                <input id="job_salary" type="text" class="form-control" @if(isset($aday->infos->job_salary)) value="{{$aday->infos->job_salary}}" @endif >
            </div>
        </div>
    </div>
</div>

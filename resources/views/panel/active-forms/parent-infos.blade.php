<div class="tab-pane fade" id="parent-info" role="tabpanel"
     aria-labelledby="parent-info-tab" data-content="6">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne Baba Birlikte Mi?</label>
                <select id="parent_together" class="form-select">
                    <option @if($aday->infos->parent_together == 'Evet') selected @endif  value="Evet">Evet</option>
                    <option @if($aday->infos->parent_together == 'Hayır') selected @endif value="Hayır">Hayır</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne Sağ Mı?</label>
                <select id="mother_alive" class="form-select">
                    <option @if($aday->infos->mother_alive == 'Evet') selected @endif  value="Evet">Evet</option>
                    <option @if($aday->infos->mother_alive == 'Hayır') selected @endif value="Hayır">Hayır</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Baba Sağ Mı?</label>
                <select id="C9l7SUqOxSvZ" class="form-select">
                    <option @if($aday->infos->C9l7SUqOxSvZ == 'Evet') selected @endif  value="Evet">Evet</option>
                    <option @if($aday->infos->C9l7SUqOxSvZ == 'Hayır') selected @endif value="Hayır">Hayır</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne Ad </label>
                <input id="mother_name" type="text" class="form-control" @if(isset($aday->infos->mother_name)) value="{{$aday->infos->mother_name}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne Soyad </label>
                <input id="mother_name" type="text" class="form-control" @if(isset($aday->infos->mother_surname)) value="{{$aday->infos->mother_surname}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Baba Ad </label>
                <input id="father_name" type="text" class="form-control" @if(isset($aday->infos->father_name)) value="{{$aday->infos->father_name}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Baba Soyad </label>
                <input id="father_name" type="text" class="form-control" @if(isset($aday->infos->father_surname)) value="{{$aday->infos->father_surname}}" @endif >
            </div>

            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Mesleği</label>
                <input id="mother_job" type="text" class="form-control" @if(isset($aday->infos->mother_job)) value="{{$aday->infos->mother_job}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Mesleği</label>
                <input id="father_job" type="text" class="form-control" @if(isset($aday->infos->father_job)) value="{{$aday->infos->father_job}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Tahsil Durumu</label>
                <input id="mother_educ" type="text" class="form-control" @if(isset($aday->infos->mother_educ)) value="{{$aday->infos->mother_educ}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Tahsil Durumu</label>
                <input id="father_educ" type="text" class="form-control" @if(isset($aday->infos->father_educ)) value="{{$aday->infos->father_educ}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Bağlı Olduğu Sosyal Güvenlik
                    Kurumu</label>
                <input id="mother_company" type="text" class="form-control" @if(isset($aday->infos->mother_company)) value="{{$aday->infos->mother_company}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                    Kurumu</label>
                <input id="father_company" type="text" class="form-control" @if(isset($aday->infos->father_company)) value="{{$aday->infos->father_company}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Kiminle Kalıyorsunuz?</label>
                <input id="WAll7WvDPAjk" type="text" class="form-control" @if(isset($aday->infos->WAll7WvDPAjk)) value="{{$aday->infos->WAll7WvDPAjk}}" @endif >
            </div>
        </div>
    </div>
</div>

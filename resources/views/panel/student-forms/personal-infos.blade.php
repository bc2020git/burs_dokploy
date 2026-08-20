<div class="tab-pane fade" id="personal-info" role="tabpanel"
     aria-labelledby="personal-info-tab" data-content="2">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="interviewDate">Doğum Tarihi</label>
                <div class="input-group">
                    <input value="{{$aday->b_dob}}" type="text" class="form-control inputDate" id="b_dob" placeholder="Tarih seçiniz">
                    <div class="input-group-append no-border">
                                                        <span class="input-group-text no-border" id="b_dobIcon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="24" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                                <path d="M14 4h-1V2.5a.5.5 0 0 0-1 0V4H4V2.5a.5.5 0 0 0-1 0V4H2a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM1 6a1 1 0 0 1 1-1h1v.5a.5.5 0 0 0 1 0V5h8v.5a.5.5 0 0 0 1 0V5h1a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6zm1 2v5h12V8H2z"/>
                                                            </svg>
                                                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Doğduğu Şehir</label>
                <select id="born_city" class="form-select">
                    @foreach($cities as $city)
                        <option @if($aday->born_city == $city->name) selected @endif data-id="{{$city->name}}" value="{{$city->name}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Doğduğu İlçe</label>
                <select id="born_district" class="form-select">
                    <option selected  value="{{$aday->born_district}}">{{$aday->born_district}}</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Nüfusa Kayıtlı Olduğu İl</label>
                <select id="registered_city" class="form-select">
                    @foreach($cities as $city)
                        <option @if($aday->registered_city == $city->name) selected @endif data-id="{{$city->name}}" value="{{$city->name}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Nüfusa Kayıtlı Olduğu İlçe</label>
                <select id="registered_district" class="form-select">
                    <option selected  value="{{$aday->registered_district}}">{{$aday->registered_district}}</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Cinsiyet</label>
                <select id="gender" class="form-select">
                    <option @if($aday->gender == 'Kadın') selected @endif value="Kadın">Kadın</option>
                    <option @if($aday->gender == 'Erkek') selected @endif value="Erkek">Erkek</option>
                    <option @if($aday->gender == 'Belirtmek İstemiyorum') selected @endif value="Belirtmek İstemiyorum">Belirtmek İstemiyorum</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Medeni Durumu</label>
                <select id="maritality" class="form-select">
                    <option @if($aday->maritality == 'Bekar') selected @endif value="Bekar">Bekar</option>
                    <option  @if($aday->maritality == 'Evli') selected @endif value="Evli">Evli</option>
                    <option  @if($aday->maritality == 'Boşanmış') selected @endif value="Boşanmış">Boşanmış</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Uyruk</label>
                <select id="nationality" class="form-select">
                    <option @if($aday->nationality == 'Türkiye') selected @endif value="Türkiye">Türkiye</option>
                    <option @if($aday->nationality == 'Diğer') selected @endif value="Diğer">Diğer</option>
                </select>
            </div>
        </div>
    </div>
</div>

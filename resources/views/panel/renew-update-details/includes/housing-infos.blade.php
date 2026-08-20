
<div class="tab-pane fade" id="place-info" role="tabpanel"
     aria-labelledby="place-info-tab" data-content="4">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Barınma Türü</label>
                <select id="housing_type" class="form-select">
                    <option @if($aday->infos->housing_type == 'Öğrenci Evi') selected @endif  value="Öğrenci Evi">Öğrenci Evi</option>
                    <option @if($aday->infos->housing_type == 'Yurt') selected @endif value="Yurt">Yurt</option>
                    <option @if($aday->infos->housing_type == 'Aile Yanı') selected @endif value="Aile Yanı">Aile Yanı</option>
                    <option @if($aday->infos->housing_type == 'Misafir') selected @endif value="Misafir">Misafir</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Ödenen Ücret</label>
                <input id="housing_fee" type="text" class="form-control" value="{{$aday->infos->housing_fee}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Birlikte Yaşanılan Kişi Sayısı</label>
                <input id="living_with_count" type="text" class="form-control"
                       value="{{$aday->infos->living_with_count}}">

            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Kaldığı İl</label>
                <select id="residing_city" class="form-select">
                    @foreach($cities as $city)
                        <option  data-id="{{$city->id}}" @if($aday->infos->residing_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Kaldığı İlçe</label>
                <select id="residing_district" class="form-select">
                    <option  selected value="{{$aday->infos->residing_district}}">{{$aday->infos->residing_district}}</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Tam Adres</label>
                <input id="address_detail" type="text" class="form-control"
                       value="{{$aday->infos->address_detail}}">
            </div>
        </div>
    </div>
</div>

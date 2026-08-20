<div class="tab-pane fade" id="place-info" role="tabpanel"
     aria-labelledby="place-info-tab" data-content="4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="housingType">Barınma Türü</label>
            <select id="housingType" class="form-select">
                <option disabled selected value="">Seçiniz...</option>
                <option @selected(isset($aday->housing->housing_type) && $aday->housing->housing_type == 'Ev') value="Ev">Ev</option>
                <option @selected(isset($aday->housing->housing_type) && $aday->housing->housing_type == 'Yurt') value="Yurt">Yurt</option>
                <option @selected(isset($aday->housing->housing_type) && $aday->housing->housing_type == 'Aile Yanı') value="Aile Yanı">Aile Yanı</option>
                <option @selected(isset($aday->housing->housing_type) && $aday->housing->housing_type == 'Arkadaş Yanı') value="Arkadaş Yanı">Arkadaş Yanı</option>
                <option @selected(isset($aday->housing->housing_type) && $aday->housing->housing_type == 'Kira') value="Kira">Kira</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="housingFee">Ödenen Ücret</label>
            <input @if(isset($aday->housing->housing_fee))value="{{$aday->housing->housing_fee}}"@endif type="text" class="form-control" id="housingFee"
                   placeholder="Ödenen ücret bilgisi giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="livingWithCount">Birlikte Yaşanılan Kişi Sayısı</label>
            <input @if(isset($aday->housing->living_with_count))value="{{$aday->housing->living_with_count}}"@endif type="text" class="form-control" id="livingWithCount"
                   placeholder="Kişi sayısı giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="residingCity">Kaldığı İl</label>
            <select onchange="getDistricts(this,'residingDistrict')" id="residingCity" class="form-select">
                <option selected disabled>Şehir Seçiniz</option>
                @foreach($cities as $city)
                    <option data-id="{{ $city->id }}"  @if(isset($aday->housing->residing_city) && $aday->housing->residing_city == $city->id) selected @endif value="{{$city->id}}">{{$city->isim}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="residingDistrict">Kaldığı İlçe</label>
            <select id="residingDistrict" class="form-select">
                @if(isset($aday->housing->residing_district)) <option selected   value="{{ $aday->housing->residing_district}}">{{$aday->housing->residing_district}}</option>@endif
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="addressDetail">Açık Adres</label>
            <input  @if(isset($aday->housing->address_detail)) value="{{$aday->housing->address_detail}}" @endif type="text" class="form-control" id="addressDetail"
                   placeholder="Adres bilgisi giriniz...">
        </div>
    </div>
</div>

<div class="step-content" id="step-2" data-content="2">
    <div class="row">
        <input type="hidden" name="form_id" value="{{$aday->id}}">
        <label for="day">Doğum Tarihi</label>
        <div class="col-md-2 mb-3">
            <select id="day" class="form-select">
                @if(isset($bolunmusTarih))
                    <option selected value="{{$bolunmusTarih[2]}}">{{$bolunmusTarih[2]}}</option>
                @else
                    <option value="">Gün seçiniz...</option>
                @endif
            </select>
        </div>
        <div class="col-md-2 mb-3">
            <select id="month" class="form-select">
                @if(isset($bolunmusTarih))
                    <option selected value="{{$bolunmusTarih[1]}}">{{$bolunmusTarih[1]}}</option>
                @else
                    <option value="">Ay seçiniz...</option>
                @endif
            </select>
        </div>
        <div class="col-md-2 mb-3">
            <select id="year" class="form-select">
                @if(isset($bolunmusTarih))
                    <option selected value="{{$bolunmusTarih[0]}}">{{$bolunmusTarih[0]}}</option>
                @else
                    <option value="">Yıl seçiniz...</option>
                @endif            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="birthCity">Doğduğu Şehir</label>
            <select onchange="getDistricts(this,'birthDistrict')" id="birthCity" class="form-select">
                <option selected disabled>Şehir Seçiniz</option>
                @foreach($cities as $city)
                    <option data-id="{{ $city->id }}"  @if( isset($aday->personal->born_city) && $aday->personal->born_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="birthDistrict">Doğduğu İlçe</label>
            <select id="birthDistrict" class="form-select">
                 @if(isset($aday->personal->born_district))<option value="{{$aday->personal->born_district}}">{{$aday->personal->born_district}}</option> @endif
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="registeredCity">Nüfusa Kayıtlı Olduğu İl</label>
            <select onchange="getDistricts(this,'registeredDistrict')"  id="registeredCity" class="form-select">
                <option selected disabled>Şehir Seçiniz</option>
            @foreach($cities as $city)
                    <option data-id="{{ $city->id }}" @if( isset($aday->personal->registered_city) && $aday->personal->registered_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>

                @endforeach            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="registeredDistrict">Nüfusa Kayıtlı Olduğu İlçe</label>
            <select id="registeredDistrict" class="form-select">
                @if(isset($aday->personal->registered_district))<option value="{{$aday->personal->registered_district}}">{{$aday->personal->registered_district}}</option>@endif
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="gender">Cinsiyet</label>
            <select id="gender" class="form-select">
                <option selected disabled>Seçiniz</option>
                <option value="Erkek" @selected(isset($aday->personal->gender) && $aday->personal->gender == 'Erkek')>Erkek</option>
                <option value="Kadın" @selected(isset($aday->personal->gender) && $aday->personal->gender == 'Kadın')>Kadın</option>
                <option value="Belirtmek İstemiyor" @selected(isset($aday->personal->gender) && $aday->personal->gender == 'Belirtmek İstemiyor')>Belirtmek İstemiyor</option>

            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="maritalStatus">Medeni Durum</label>
            <select id="maritalStatus" class="form-select">
                <option selected disabled>Seçiniz</option>
                <option value="Evli" @selected(isset($aday->personal->maritality) && $aday->personal->maritality == 'Evli')>Evli</option>
                <option value="Bekar" @selected(isset($aday->personal->maritality) && $aday->personal->maritality == 'Bekar')>Bekar</option>
                <option value="Boşanmış" @selected(isset($aday->personal->maritality) && $aday->personal->maritality == 'Boşanmış')>Boşanmış</option>

            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nationality">Uyruk</label>
            <select id="nationality" class="form-select">
                <option value="">Seçiniz...</option>
                <option value="Diğer" @selected(isset($aday->personal->nationality) && $aday->personal->nationality == 'Diğer')>Diğer</option>
                <option value="Türkiye" @selected(isset($aday->personal->nationality) && $aday->personal->nationality == 'Türkiye')>Türkiye</option>

            </select>
        </div>
    </div>
</div>

<div class="step-content" id="step-5" data-content="5">
    <input type="hidden" id="form_id" name="form_id" value="{{$aday->id}}">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="motherCity">Annenin Yaşadığı İl</label>
            <select onchange="getDistricts(this,'motherDistrict')" id="motherCity" class="form-select">
                <option selected disabled>Şehir Seçiniz</option>
                @foreach($cities as $city)
                    <option data-id="{{ $city->id }}"  @if( isset($aday->family->mother_city) && $aday->family->mother_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>

                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="fatherCity">Babanın Yaşadığı İl</label>
            <select onchange="getDistricts(this,'fatherDistrict')" id="fatherCity" class="form-select">
                <option selected disabled>Şehir Seçiniz</option>
                @foreach($cities as $city)
                    <option data-id="{{ $city->id }}"  @if( isset($aday->family->father_city) && $aday->family->father_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="motherDistrict">Annenin Yaşadığı İlçe</label>
            <select id="motherDistrict" class="form-select">
                @if(isset($aday->family->mother_district)) <option selected value="{{$aday->family->mother_district}}">{{$aday->family->mother_district}}</option>@endif
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="fatherDistrict">Babanın Yaşadığı İlçe</label>
            <select id="fatherDistrict" class="form-select">
                @if(isset($aday->family->father_district))<option selected value="{{$aday->family->father_district}}">{{$aday->family->father_district}}</option>@endif
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="address">Açık Adres</label>
            <input type="text" value="@if(isset($aday->family->parent_address)) {{$aday->family->parent_address}} @endif" id="address" class="form-control" placeholder="Adres bilgisi giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="parentMobile">Ailenin Cep Telefonu</label>
            <input type="text" value="@if(isset($aday->family->parent_mobile)) {{$aday->family->parent_mobile}} @endif" id="parentMobile" class="form-control"
                   placeholder="Telefon numarası giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="parentHomePhone">Ailenin Ev Telefonu</label>
            <input value="@if(isset($aday->family->parent_phone)) {{$aday->family->parent_phone}} @endif" type="text" id="parentHomePhone" class="form-control"
                   placeholder="Telefon numarası giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="parentEmail">Ailenin E-posta Adresi</label>
            <input value="@if(isset($aday->family->parent_email)) {{$aday->family->parent_email}} @endif" type="email" id="parentEmail" class="form-control"
                   placeholder="E-posta adresi giriniz...">
        </div>
    </div>
    <div class="urgent">
        <div class="row">
            <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"
                        fill="black" />
                </svg> Acil Durum Kişisi</p>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="adSoyad" class="form-label">Adı Soyadı</label>
                    <input value="@if(isset($aday->family->emergency_person)) {{$aday->family->emergency_person}} @endif" type="text" class="form-control" id="adSoyad"
                           placeholder="Ad soyad bilgisi giriniz...">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefon" class="form-label">Telefon</label>
                    <input value="@if(isset($aday->family->emergency_mobile)) {{$aday->family->emergency_mobile}} @endif" type="text" class="form-control" id="telefon"
                           placeholder="Telefon numarası giriniz...">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="yakınlıkDerecesi" class="form-label">Yakınlık Derecesi</label>
                    <input value="@if(isset($aday->family->emergency_closeness)) {{$aday->family->emergency_closeness}} @endif" type="text" class="form-control" id="yakınlıkDerecesi"
                           placeholder="Yakınlık derecesi giriniz...">
                </div>
            </div>
        </div>
    </div>
</div>

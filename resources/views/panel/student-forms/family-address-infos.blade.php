
<div class="tab-pane fade" id=" family-address-info" role="tabpanel"
     aria-labelledby=" family-address-info-tab" data-content="5">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Yaşadığı İl</label>
                <select id="mother_city" class="form-select">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                    @foreach($cities as $city)
                        <option  data-id="{{$city->name}}" @if($aday->mother_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Yaşadığı İl</label>
                <select id="father_city" class="form-select">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                    @foreach($cities as $city)
                        <option  data-id="{{$city->name}}" @if($aday->father_city == $city->name) selected @endif value="{{$city->name}}">{{$city->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Yaşadığı İlçe</label>
                <select id="mother_district" class="form-select">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                    <option  selected value="{{$aday->mother_district}}">{{$aday->mother_district}}</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Yaşadığı İlçe</label>
                <select id="father_district" class="form-select">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                    <option  selected value="{{$aday->father_district}}">{{$aday->father_district}}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Açık Adres</label>
                <input id="parent_address" type="text" class="form-control"
                       value="{{$aday->parent_address}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label" for="phone">Aile Cep Telefonu</label>
                <br>
                <input type="tel" id="parent_mobile" value="{{$aday->parent_mobile}}" class="form-control telinputs" placeholder="+90 506 144 5288"
                       style="width:390px ; ">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Aile Ev Telefonu</label>
                <input id="parent_phone" type="text" class="form-control"
                       value="{{$aday->parent_phone}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Aile E-posta Adresi</label>
                <input id="parent_email" type="text" class="form-control"
                       value="{{$aday->parent_email}}">
            </div>
        </div>
        <div class="urgent">
            <div class="row">
                <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"
                            fill="black" />
                    </svg> Acil Durum Kişisi</p>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Ad</label>
                    <input type="text" class="form-control " id="emergency_person_name" value="{{$aday->emergency_person_name}}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Soyad</label>
                    <input type="text" class="form-control " id="emergency_person_surname" value="{{$aday->emergency_person_surname}}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Yakınlık Derecesi</label>
                    <input type="text" class="form-control " id="emergency_closeness" value="{{$aday->emergency_closeness}}">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Cep Telefonu</label>
                    <input type="text" class="form-control telinputs " id='emergency_mobile' value="{{$aday->emergency_mobile}}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">E-Posta Adresi</label>
                    <input type="text" class="form-control " value="">
                </div>
            </div>
        </div>
    </div>
</div>

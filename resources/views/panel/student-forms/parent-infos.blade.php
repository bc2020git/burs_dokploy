
<div class="tab-pane fade" id="parent-info" role="tabpanel"
     aria-labelledby="parent-info-tab" data-content="6">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne Baba Birlikte Mi?</label>
                <select id="parent_together" class="form-select">
                    <option @if($aday->parent_together == 'Evet') selected @endif  value="Evet">Evet</option>
                    <option @if($aday->parent_together == 'Hayır') selected @endif value="Hayır">Hayır</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne  Sağ Mı?</label>
                <select id="mother_alive" class="form-select">
                    <option @if($aday->mother_alive == 'Evet') selected @endif  value="Evet">Evet</option>
                    <option @if($aday->mother_alive == 'Hayır') selected @endif value="Hayır">Hayır</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Baba Sağ Mı?</label>
                <select id="C9l7SUqOxSvZ" name='C9l7SUqOxSvZ' class="form-select">
                    <option @if($aday->C9l7SUqOxSvZ == 'Evet') selected @endif  value="Evet">Evet</option>
                    <option @if($aday->C9l7SUqOxSvZ == 'Hayır') selected @endif value="Hayır">Hayır</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne Ad </label>
                <input id="mother_name" type="text" class="form-control" value="{{$aday->mother_name}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Anne Soyad</label>
                <input id="mother_surname"  value="{{$aday->mother_surname}}" type="text" class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Baba Ad</label>
                <input id="father_name" type="text" class="form-control" value="{{$aday->father_name}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Baba Soyad</label>
                <input id="father_surname"  value="{{$aday->father_surname}}" type="text" class="form-control">

            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Mesleği</label>
                <input id="mother_job" type="text" class="form-control" value="{{$aday->mother_job}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Mesleği</label>
                <input id="father_job" type="text" class="form-control" value="{{$aday->father_job}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Tahsil Durumu</label>
                <select class="form-select" id="mother_educ">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                     <option @if($aday->mother_educ == 'İlkokul') selected @endif  value="İlkokul">İlkokul</option>
                     <option @if($aday->mother_educ == 'Ortaokul') selected @endif  value="Ortaokul">Ortaokul</option>
                     <option @if($aday->mother_educ == 'Lise') selected @endif  value="Lise">Lise</option>
                     <option @if($aday->mother_educ == 'Ön Lisans') selected @endif  value="Ön Lisans">Ön Lisans</option>
                     <option @if($aday->mother_educ == 'Lisans') selected @endif  value="Lisans">Lisans</option>
                     <option @if($aday->mother_educ == 'Yüksek Lisans') selected @endif  value="Yüksek Lisans">Yüksek Lisans</option>
                     <option @if($aday->mother_educ == 'Doktora') selected @endif  value="Doktora">Doktora</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Tahsil Durumu</label>
                <select class="form-select" id="father_educ">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                    <option @if($aday->father_educ == 'İlkokul') selected @endif  value="İlkokul">İlkokul</option>
                    <option @if($aday->father_educ == 'Ortaokul') selected @endif  value="Ortaokul">Ortaokul</option>
                    <option @if($aday->father_educ == 'Lise') selected @endif  value="Lise">Lise</option>
                    <option @if($aday->father_educ == 'Ön Lisans') selected @endif  value="Ön Lisans">Ön Lisans</option>
                    <option @if($aday->father_educ == 'Lisans') selected @endif  value="Lisans">Lisans</option>
                    <option @if($aday->father_educ == 'Yüksek Lisans') selected @endif  value="Yüksek Lisans">Yüksek Lisans</option>
                    <option @if($aday->father_educ == 'Doktora') selected @endif  value="Doktora">Doktora</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Bağlı Olduğu Sosyal Güvenlik
                    Kurumu</label>
                <select class="form-select" id="mother_company">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                    <option @if($aday->mother_company == 'SGK') selected @endif  value="SGK">SGK</option>
                    <option @if($aday->mother_company == 'BAĞ-KUR') selected @endif value="BAĞ-KUR">BAĞ-KUR</option>
                    <option @if($aday->mother_company == 'Yok') selected @endif value="Yok">Yok</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                    Kurumu</label>
                <select class="form-select" id="father_company">
                    <option selected disabled value="seçiniz">Seçiniz..</option>
                    <option @if($aday->father_company == 'SGK') selected @endif  value="SGK">SGK</option>
                    <option @if($aday->father_company == 'BAĞ-KUR') selected @endif value="BAĞ-KUR">BAĞ-KUR</option>
                    <option @if($aday->father_company == 'Yok') selected @endif value="Yok">Yok</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Kiminle Kalıyorsunuz?</label>
                <input id="WAll7WvDPAjk" type="text" class="form-control" value="@if(isset($aday->WAll7WvDPAjk)){{$aday->WAll7WvDPAjk}} @endif" placeholder="Kiminle kalıyorsunuz giriniz..">
            </div>
        </div>
    </div>
</div>

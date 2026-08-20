<div class="step-content" id="step-6" data-content="6">
    <input type="hidden" class="form-control" id="tc_no" value="{{ Auth::guard('aday')->user()->tc_no }}">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="anneBabaBirlikte" class="form-label">Anne Baba Birlikte mi?</label>
            <select class="form-select" id="anneBabaBirlikte" required>
                <option selected disabled>Seçiniz...</option>
                <option @selected(isset($aday->parent->parent_together) && $aday->parent->parent_together == 'Evet') value="Evet">Evet</option>
                <option @selected(isset($aday->parent->parent_together) && $aday->parent->parent_together == 'Hayır') value="Hayır">Hayır</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="anneBabaSag" class="form-label">Anne Baba Sağ mı?</label>
            <select class="form-select" id="anneBabaSag" required>
                <option selected disabled>Seçiniz...</option>
                <option @selected(isset($aday->parent->mother_alive) && $aday->parent->mother_alive == 'Evet') value="Evet">Evet</option>
                <option @selected(isset($aday->parent->mother_alive) && $aday->parent->mother_alive == 'Hayır') value="Hayır">Hayır</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="babaAdSoyad" class="form-label">Baba Ad Soyad</label>
            <input value="@if(isset($aday->parent->father_name)){{$aday->parent->father_name}} @endif" type="text" class="form-control" id="babaAdSoyad" placeholder="Ad soyad giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="anneAdSoyad" class="form-label">Anne Ad Soyad</label>
            <input value="@if(isset($aday->parent->mother_name)){{$aday->parent->mother_name}} @endif" type="text" class="form-control" id="anneAdSoyad" placeholder="Ad soyad giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="babaninMeslegi" class="form-label">Babanın Mesleği</label>
            <input value="@if(isset($aday->parent->father_job)){{$aday->parent->father_job}} @endif" type="text" class="form-control" id="babaninMeslegi"
                   placeholder="Meslek bilgisi giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="anneninMeslegi" class="form-label">Annenin Mesleği</label>
            <input value="@if(isset($aday->parent->mother_job)){{$aday->parent->mother_job}} @endif" type="text" class="form-control" id="anneninMeslegi"
                   placeholder="Meslek bilgisi giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="babaninTahsilDurumu" class="form-label">Babanın Tahsil Durumu</label>
            <input value="@if(isset($aday->parent->father_educ)){{$aday->parent->father_educ}} @endif" type="text" class="form-control" id="babaninTahsilDurumu"
                   placeholder="Tahsil durumu giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="anneninTahsilDurumu" class="form-label">Annenin Tahsil Durumu</label>
            <input value="@if(isset($aday->parent->mother_educ)){{$aday->parent->mother_educ}} @endif" type="text" class="form-control" id="anneninTahsilDurumu"
                   placeholder="Tahsil durumu giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="babaninSosyalGuvenlik" class="form-label">Babanın Bağlı Olduğu Sosyal Güvenlik
                Kurumu</label>
            <input value="@if(isset($aday->parent->father_company)){{$aday->parent->father_company}} @endif" type="text" class="form-control" id="babaninSosyalGuvenlik"
                   placeholder="Kurum bilgisi giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="anneninSosyalGuvenlik" class="form-label">Annenin Bağlı Olduğu Sosyal Güvenlik
                Kurumu</label>
            <input value="@if(isset($aday->parent->mother_company)){{$aday->parent->mother_company}} @endif" type="text" class="form-control" id="anneninSosyalGuvenlik"
                   placeholder="Kurum bilgisi giriniz...">
        </div>
    </div>
</div>

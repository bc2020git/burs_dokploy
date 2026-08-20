<div class="tab-pane fade" id="income-info" role="tabpanel"
     aria-labelledby="income-info-tab" data-content="8">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Ailenin Geçmişini Kim/Kimler Sağlıyor?</label>
                <input id="income_person" type="text" class="form-control" @if(isset($aday->infos->income_person)) value="{{$aday->infos->income_person}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye
                    Bakıyor?</label>
                <input id="total_person" type="text" class="form-control" @if(isset($aday->infos->total_person)) value="{{$aday->infos->total_person}}" @endif >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                <input id="mother_salary" type="text" class="form-control" @if(isset($aday->infos->mother_salary)) value="{{$aday->infos->mother_salary}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                <input id="father_salary" type="text" class="form-control" @if(isset($aday->infos->father_salary)) value="{{$aday->infos->father_salary}}" @endif >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Diğer Kişilerin Aylık Net Geliri (TL)</label>
                <input id="other_salary" type="text" class="form-control" @if(isset($aday->infos->other_salary)) value="{{$aday->infos->other_salary}}" @endif >
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Ailenin Başka Geliri Var Mı?</label>
                <input id="other_income" type="text" class="form-control" @if(isset($aday->infos->other_income)) value="{{$aday->infos->other_income}}" @endif >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                <select class="form-select" id="parent_housing_type" required>
                    <option selected disabled>Seçiniz...</option>
                   <option @if($aday->infos->parent_housing_type == 'Kendi Evi') selected @endif value="Kendi Evi">Kendi Evi</option>
                   <option @if($aday->infos->parent_housing_type == 'Kiralık') selected @endif value="Kiralık">Kiralık</option>
                   <option @if($aday->infos->parent_housing_type == 'Misafir') selected @endif value="Misafir">Misafir</option>
                   <option @if($aday->infos->parent_housing_type == 'Diğer') selected @endif value="Diğer">Diğer</option>
                </select>            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                <input id="rent_count" type="text" class="form-control" @if(isset($aday->infos->rent_count)) value="{{$aday->infos->rent_count}}" @endif >
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Diğer</label>
                <input id="other_detail" type="text" class="form-control" @if(isset($aday->infos->other_detail)) value="{{$aday->infos->other_detail}}" @endif >
            </div>
        </div>
    </div>
</div>

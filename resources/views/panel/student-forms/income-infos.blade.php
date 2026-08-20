
<div class="tab-pane fade" id="income-info" role="tabpanel"
     aria-labelledby="income-info-tab" data-content="8">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Ailenin Geçmişini Kim/Kimler
                    Sağlıyor?</label>
                <input id="income_person" type="text" class="form-control" value="{{$aday->income_person}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç
                    Kişiye
                    Bakıyor?</label>
                <input id="total_person" type="number" class="form-control" value="{{$aday->total_person}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                <input id="mother_salary" type="text" class="form-control"
                       value="{{$aday->mother_salary}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                <input id="father_salary" type="text" class="form-control"
                       value="{{$aday->father_salary}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Diğer Kişilerin Aylık Net Geliri
                    (TL)</label>
                <input id="other_salary" type="text" class="form-control"
                       value="{{$aday->other_salary}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Ailenin Başka Geliri Var Mı?</label>
                <input id="other_income" type="text" class="form-control" value="{{$aday->other_income}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                <select class="form-select" id="parent_housing_type" required>
                    <option selected disabled>Seçiniz...</option>
                   <option @if($aday->parent_housing_type == 'Kendi Evi') selected @endif value="Kendi Evi">Kendi Evi</option>
                   <option @if($aday->parent_housing_type == 'Kiralık') selected @endif value="Kiralık">Kiralık</option>
                   <option @if($aday->parent_housing_type == 'Misafir') selected @endif value="Misafir">Misafir</option>
                   <option @if($aday->parent_housing_type == 'Diğer') selected @endif value="Diğer">Diğer</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                <input id="rent_count" type="text" class="form-control" value="{{$aday->rent_count}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Diğer</label>
                <input id="other_detail" type="text" class="form-control" value="{{$aday->other_detail}}">
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6 mb-3">
        <label for="gecimiSaglayanKisiler" class="form-label">Ailenin Geçimini Kim/Kimler
            sağlıyor?</label>
        <input value="@if(isset($aday->income->income_person)) {{$aday->income->income_person}} @endif "  type="text" class="form-control" id="gecimiSaglayanKisiler"
               placeholder="Kişi bilgisi giriniz...">
    </div>
    <div class="col-md-6 mb-3">
        <label for="saglayanKisilerToplam" class="form-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç
            Kişiye Bakıyor?</label>
        <input value="@if(isset($aday->income->total_person)) {{$aday->income->total_person}} @endif " type="text" class="form-control" id="saglayanKisilerToplam"
               placeholder="Kişi bilgisi giriniz...">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="babaninGeliri" class="form-label">Babanın Aylık Net Geliri (TL)</label>
        <input value="@if(isset($aday->income->father_salary)) {{$aday->income->father_salary}} @endif " type="text" class="form-control" id="babaninGeliri"
               placeholder="Gelir bilgisi giriniz...">
    </div>
    <div class="col-md-6 mb-3">
        <label for="anneninGeliri" class="form-label">Annenin Aylık Net Geliri (TL)</label>
        <input value="@if(isset($aday->income->mother_salary)) {{$aday->income->mother_salary}} @endif " type="text" class="form-control" id="anneninGeliri"
               placeholder="Gelir bilgisi giriniz...">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="digerKisilerinGeliri" class="form-label">Diğer kişilerin Aylık Net Geliri
            (TL)</label>
        <input value="@if(isset($aday->income->other_salary)) {{$aday->income->other_salary}} @endif" type="text" class="form-control" id="digerKisilerinGeliri"
               placeholder="Kişi bilgisi giriniz...">
    </div>
    <div class="col-md-6 mb-3">
        <label for="baskaGelir" class="form-label">Ailenin Başka Geliri Var mı? (Kira vb.)</label>
        <input value="@if(isset($aday->income->other_income)) {{$aday->income->other_income}} @endif" type="text" class="form-control" id="baskaGelir"
               placeholder="Gelir bilgisi giriniz...">
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="evTuru" class="form-label">Ailenin yaşamakta olduğu ev türü?</label>
        <select class="form-select" id="evTuru" required>
            <option selected disabled>Seçiniz...</option>
            <option @selected( isset($aday->income->housing_type) && $aday->income->housing_type == 'Kendi Evi') value="Kendi Evi">Kendi Evi</option>
            <option @selected( isset($aday->income->housing_type) && $aday->income->housing_type == 'Kiralık') value="Kiralık">Kiralık</option>
            <option @selected( isset($aday->income->housing_type) && $aday->income->housing_type == 'Misafir') value="Misafir">Misafir</option>
            <option @selected( isset($aday->income->housing_type) && $aday->income->housing_type == 'Diğer') value="Diğer">Diğer</option>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="kira" class="form-label">Kira ise* Aylık Net Kirası (TL)</label>
        <input value="@if(isset($aday->income->rent_count)) {{$aday->income->rent_count}} @endif" type="text" class="form-control" id="kira" placeholder="Kişi bilgisi giriniz...">
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label for="digerAciklama" class="form-label">Diğer ise* Açıklama</label>
        <input value="@if(isset($aday->income->other_detail)) {{$aday->income->other_detail}} @endif" type="text" class="form-control" id="digerAciklama"
               placeholder="Açıklama giriniz...">
    </div>
</div>

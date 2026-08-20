<div class="step-content" id="step-13" data-content="13">
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="form_id" name="form_id" value="{{$aday->id}}">


            <div class="form-group mb-3">
                <label for="employment-status">Düzenli olarak bir kurumda kazanç sağlıyor
                    mu?</label>
                <select id="employment-status" class="form-select">
                    <option value="" disabled selected>Seçiniz...</option>
                    <option @selected(isset($aday->job->is_working) && $aday->job->is_working == 'Full-time') value="Full-time">Evet, tam zamanlı çalışıyor</option>
                    <option @selected(isset($aday->job->is_working) && $aday->job->is_working == 'Part-time') value="Part-time">Evet, yarı zamanlı çalışıyor</option>
                    <option @selected(isset($aday->job->is_working) && $aday->job->is_working == 'Stajyer') value="Stajyer">Evet, stajyer olarak çalışıyor</option>
                    <option @selected(isset($aday->job->is_working) && $aday->job->is_working == 'Hayır') value="Hayır">Hayır</option>
                    <option @selected(isset($aday->job->is_working) && $aday->job->is_working == 'Diğer') value="Diğer">Diğer</option>
                </select>
            </div>
            <div id="employment-details" class="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kurumAdi" class="form-label">Kurum Adı</label>
                        <input value="@if(isset($aday->job->company)) {{$aday->job->company}}@endif" type="text" class="form-control" id="kurumAdi"
                               placeholder="Kurum adı giriniz...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gorev" class="form-label">Görev</label>
                        <input value="@if(isset($aday->job->job_rank)) {{$aday->job->job_rank}}@endif" type="text" class="form-control" id="gorev"
                               placeholder="Görev giriniz...">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="social-security">Sosyal Güvenlik Kurumu</label>
                        <select id="social-security" class="form-select">
                            <option value="" selected>Seçiniz...</option>
                            <option @selected(isset($aday->job->sgk) && $aday->job->sgk == 'sgk') value="sgk">SGK</option>
                            <option @selected(isset($aday->job->sgk) && $aday->job->sgk == 'ssk') value="ssk">SGK</option>
                            <option @selected(isset($aday->job->sgk) && $aday->job->sgk == 'bagkur') value="bagkur">BAĞ-KUR</option>
                            <option @selected(isset($aday->job->sgk) && $aday->job->sgk == 'Yok') value="Yok">Yok</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="aylikKazanc" class="form-label">Aylık Net Kazanç (TL)</label>
                        <input value="@if(isset($aday->job->salary)) {{$aday->job->salary}}@endif" type="text" class="form-control" id="aylikKazanc"
                               placeholder="Görev giriniz...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tab-pane fade" id="social-info" role="tabpanel"
     aria-labelledby="social-info-tab" data-content="11">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Bizden Nasıl Haberdar Oldunuz?</label>
                <select class="form-select" id="platform" required>
                    <option selected disabled>Seçiniz...</option>
                    <option @if($aday->infos->platform == 'Sosyal Medya') selected @endif value="Sosyal Medya">Sosyal Medya</option>
                    <option @if($aday->infos->platform == 'Web Sitesi') selected @endif value="Web Sitesi">Web Sitesi</option>
                    <option @if($aday->infos->platform == 'Diğer') selected @endif value="Diğer">Diğer</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Güçlü Yanlarınızın Ne olduğunu
                    Düşünüyorsunuz?</label>
                <input id="skills" type="text" class="form-control" value="{{$aday->infos->skills}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Katkıda Bulunduğunuz Sosyal Projeler</label>
                <input id="social_projects" type="text" class="form-control"
                       value="{{$aday->infos->social_projects}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Hobileriniz</label>
                <input id="hobbies" type="text" class="form-control" value="{{$aday->infos->hobbies}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
                <input id="sports" type="text" class="form-control" value="{{$aday->infos->sports}}">
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Son Okuduğunuz Kitaplar</label>
                <input id="last_books" type="text" class="form-control"
                       value="{{$aday->infos->last_books}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <label class="custom-label">Bize Mesajınız</label>
                <input id="message" type="text" class="form-control"
                       value="{{$aday->infos->message}}">
            </div>
        </div>
    </div>
</div>

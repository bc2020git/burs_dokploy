<div class="step-content" id="step-11" data-content="11">
    <input type="hidden" id="form_id" name="form_id" value="{{$aday->id}}">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="haberKaynak" class="form-label">Bizden Nasıl Haberdar Oldunuz?</label>
            <input value="@if(isset($aday->social->platform)) {{$aday->social->platform}} @endif" type="text" class="form-control" id="haberKaynak" placeholder="Açıklama giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="gucluYanlar" class="form-label">Güçlü Yanlarınızın Neler Olduğunu
                Düşünüyorsunuz?</label>
            <input value="@if(isset($aday->social->skills)) {{$aday->social->skills}} @endif" type="text" class="form-control" id="gucluYanlar" placeholder="Güçlü yan giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="sosyalProjeler" class="form-label">Katkıda Bulunduğunuz Sosyal Projeler</label>
            <input value="@if(isset($aday->social->social_projects)) {{$aday->social->social_projects}} @endif" type="text" class="form-control" id="sosyalProjeler"
                   placeholder="Proje bilgisi giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="hobiler" class="form-label">Hobileriniz</label>
            <input value="@if(isset($aday->social->hobbies)) {{$aday->social->hobbies}} @endif" type="text" class="form-control" id="hobiler" placeholder="Hobi bilgisi giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="sporDali" class="form-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
            <input value="@if(isset($aday->social->sports)) {{$aday->social->sports}} @endif" type="text" class="form-control" id="sporDali"
                   placeholder="Spor dalı bilgisi giriniz...">
        </div>
        <div class="col-md-6 mb-3">
            <label for="kitaplar" class="form-label">Son Okuduğunuz Kitaplar</label>
            <input value="@if(isset($aday->social->last_books)) {{$aday->social->last_books}} @endif" type="text" class="form-control" id="kitaplar" placeholder="Kitap adı giriniz...">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="mesaj" class="form-label">Bize Mesajınız</label>
            <textarea class="form-control" id="mesaj" rows="3"
                      placeholder="Mesajınızı giriniz...">@if(isset($aday->social->message)) {{$aday->social->message}} @endif</textarea>
        </div>
    </div>
</div>

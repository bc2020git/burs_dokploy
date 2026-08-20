<div class="mb-3">
    <label for="name" class="form-label">Soru Adı <span style="color: red" > (Yönetici sayfasında görüntülenecek olan ad) </span></label>
    <input required name='name' type="text" class="form-control" value="@if(isset($soru->name)) {{$soru->name}} @endif" id="name"
           placeholder="Ad bilgisi giriniz..">
</div>
<div class="mb-3">
    <label for="title" class="form-label">Soru Başlığı <span style="color: red" > (Başvuru formunda görüntülenecek olan metin) </span></label>
    <input required value="@if(isset($soru->title)) {{$soru->title}} @endif" name='title' type="text" class="form-control" id="title"
           placeholder="Başlık bilgisi giriniz..">
</div>

<div class="mb-3">
    <label for="required" class="custom-label">Zorunluluk</label>
    <select required id="required" name="required" class="form-select">
        <option value="Zorunlu">Zorunlu</option>
        <option value="Opsiyonel">Zorunlu Değil</option>
    </select>
</div>

<div class="mb-3">
    <label for="disabled" class="custom-label">Doldurulabilir Mi?</label>
    <select required id="disabled" name="disabled" class="form-select">
        <option value="notdisabled">Evet</option>
        <option value="disabled">Hayır</option>
    </select>
</div>
<div class="mb-3">
    <label for="on_register_form" class="custom-label"> Kayıt Ekranında Mı?</label>
    <select required id="on_register_form" name="on_register_form" class="form-select">
        <option value="1">Evet</option>
        <option value="0">Hayır</option>
    </select>
</div>
<div class="mb-3">
    <label for="forms" class="custom-label">Gösterilen Formlar <span style="color: red" >(Birden fazla seçmek için CTRL basılı tutunuz) </span></label>
    <select required style="min-height: 160px" multiple id="forms" name="forms[]" class="form-select">
        <option  value="ilkokul">İlkokul</option>
        <option  value="ortaokul">Ortaokul</option>
        <option  value="lise">Lise</option>
        <option  value="onlisans">Ön lisans</option>
        <option  value="lisans">Lisans</option>
        <option  value="yukseklisans">Yükseklisans</option>
        <option  value="doktora">Doktora</option>
    </select>
</div>

<div class="mb-3">
    <label for="type" class="custom-label">Soru Tipi</label>
    <select required id="type"  name="type" class="form-select">
        <option value="text">Metin</option>
        <option value="email">Eposta Adresi</option>
        <option value="date">Tarih</option>
        <option value="number">Numara</option>
        <option value="email">Eposta</option>
        <option value="select">Seçenek</option>
        <option value="checkbox">Kutucuk</option>
        <option value="file">Dosya</option>
        <option value="tel">Telefon Numarasi</option>
    </select>
</div>
<div id="attributeDiv" class="d-none">
    <!-- Select icin div -->
    <div class="row">
        <div class="col-md-6">
            <label for="dataset" class="form-label">Verí Kumesi</label>
        </div>
        <div class="col-md-6">
            <select id="dataset"  name="dataset" class="form-select">

                <option >Seçiniz</option>
                <option value="Univercities">Üniversiteler</option>
                <option value="Cities">Şehirler</option>
                <option value="Banks">Bankalar</option>

            </select>
        </div>
    </div>
    <div id="optiondiv" class="select-options attribute-div d-none">
        <div class="row" id="optionparentdiv" >
            <div class="col-md-3">
                <button type="button" id="addOptionButton" class="btn btn-primary mb-2">Seçenek Ekle</button>
            </div>

            <div class="col-md-12">
                <input class="form-control" type="text" name="options[]" placeholder="Seçenek Giriniz" >
            </div>
        </div>
    </div>
    <!-- Kutucuk icin div -->
    <div id="checkboxdiv" class="select-options  attribute-div d-none">
        <label for="checkboxTitle" class="form-label">Kutucuk Tipi</label>
        <select name="options[]" id="checkboxTypeSelect">
            <option selected >Seçiniz</option>
            <option  value="modal">Açılır Pencere</option>
            <option  value="link">link</option>
        </select>
        <div id="checkboxLinkDiv" class="d-none">
            <div class="card border">
                <label for="checkboxTitle" class="form-label">Açılan Link</label>
                <input  name='options[]' type="text" class="form-control" id="checkboxTitle"
                        placeholder="Başlık bilgisi giriniz..">
            </div>
        </div>
        <div id="checkboxModalDiv" class="d-none" >
            <div class="card border">
                <label for="checkboxTitle" class="form-label">Açılan Pencere Başlığı</label>
                <input  name='options[]' type="text" class="form-control" id="checkboxTitle"
                        placeholder="Başlık bilgisi giriniz..">
            </div>
            <div class="card border">
                <label for="checkboxContent" class="form-label">Açılan Pencere İçeriği</label>

                <textarea name="options[]" id="checkboxContent" cols="30" rows="10">İçeriği Giriniz...</textarea>
            </div>

        </div>
    </div>
</div>

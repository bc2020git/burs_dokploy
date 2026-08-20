document.addEventListener('DOMContentLoaded', function () {
    const okulTipiSelect = document.getElementById('okul-tipi');
    const gelirBilgileriContainer = document.getElementById('gelir-bilgileri');

    okulTipiSelect.addEventListener('change', function () {
        const selectedValue = this.value;
        gelirBilgileriContainer.innerHTML = ''; // Gelir bilgilerini temizle

        if (selectedValue === 'ortaogretim') {
            addOrtaogretimGelirSorulari(gelirBilgileriContainer);
        } else if (selectedValue === 'yuksekogretim') {
            addYuksekogretimGelirSorulari(gelirBilgileriContainer);
        }
    });

    function addOrtaogretimGelirSorulari(container) {
        container.innerHTML = `
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Ailenin Geçimini Kim/Kimler Sağlıyor?</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor?</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Diğer Kişilerin Aylık Net Geliri (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Diğer ise Açıklama</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
        `;
    }

    function addYuksekogretimGelirSorulari(container) {
        container.innerHTML = `
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Ailenin Geçimini Kim/Kimler Sağlıyor?</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor?</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Diğer Kişilerin Aylık Net Geliri (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-6 form-group">
                    <label class="custom-label">Diğer ise Açıklama</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <label class="custom-label">Kredi borcu ödüyor musunuz? Ödüyorsanız tutarı ile birikte yazınız</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
                <div class="col-md-12 form-group">
                    <label class="custom-label">Herhangi bir işte çalışıyor musunuz? Evet ise çalışma şekliniz ve aylık gelirinizi belirtiniz</label>
                    <input type="text" class="form-control" placeholder="">
                </div>
            </div>
        `;
    }
});

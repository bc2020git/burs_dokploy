<script>
    // Gelir Bilgileri
    const aileninYasamaktaOlduguEvTuru = $('#parent_housing_type');
    const kiraIseAylikNetKirasi = $('#rent_count');
    const kiraLabel = $('#rent_count').parent().find('label');
    const originalLabel = kiraLabel.text().replace('*', '');

    const otherDetail = $('#other_detail');
    const otherLabel = $('#other_detail').parent().find('label');
    const originalOtherLabel = otherLabel.text().replace('*', '');

    // Ebeveyn Bilgileri

    // Engel Bilgileri
    const engelDurumu = $('#disabled_status');
    const engelAciklama = $('#disabled_detail');
    const engelLabel = $('#disabled_detail').parent().find('label');
    const originalEngelLabel = engelLabel.text().replace('*', '');

    function handleDisabledDetailRequirement(isRequired) {
        if (isRequired) {
            engelAciklama.prop('required', true).prop('disabled', false);
            engelLabel.html(originalEngelLabel + ' <span class="text-danger">*</span>');
        } else {
            engelAciklama.prop('required', false).prop('disabled', true).val('');
            engelLabel.text(originalEngelLabel);
        }
    }

    function handleRentFieldRequirement(isRequired) {
        if (isRequired) {
            kiraIseAylikNetKirasi.prop('required', true).prop('disabled', false);
            kiraLabel.html(originalLabel + ' <span class="text-danger">*</span>');
        } else {
            kiraIseAylikNetKirasi.prop('required', false).prop('disabled', true).val('');
            kiraLabel.text(originalLabel);
        }
    }

    function handleOtherFieldRequirement(isRequired) {
        if (isRequired) {
            otherDetail.prop('required', true).prop('disabled', false);
            otherLabel.html(originalOtherLabel + ' <span class="text-danger">*</span>');
        } else {
            otherDetail.prop('required', false).prop('disabled', true).val('');
            otherLabel.text(originalOtherLabel);
        }
    }

    // Sayfa yüklendiğinde kontrol
    $(document).ready(function() {
        const selectedValue = aileninYasamaktaOlduguEvTuru.val();
        handleRentFieldRequirement(selectedValue === 'Kiralık');
        handleOtherFieldRequirement(selectedValue === 'Diğer');

        // Engel durumu kontrolü
        handleDisabledDetailRequirement(engelDurumu.val() === 'Evet');
    });

    // Select değiştiğinde kontrol
    aileninYasamaktaOlduguEvTuru.on('change', function() {
        const selectedValue = $(this).val();
        handleRentFieldRequirement(selectedValue === 'Kiralık');
        handleOtherFieldRequirement(selectedValue === 'Diğer');
    });

    // Engel durumu değiştiğinde kontrol
    engelDurumu.on('change', function() {
        const selectedValue = $(this).val();
        handleDisabledDetailRequirement(selectedValue === 'Evet');
    });



    // İban Kontrolü // IBAN kontrolü
        const ibanInput = document.getElementById('iban');
        if (ibanInput) {
                        function validateAndFormatIBAN(value) {
                // Tüm boşlukları kaldır ve büyük harfe çevir
                value = value.toUpperCase().replace(/\s/g, '');

                // TRTR ile başlıyorsa ilk TR'yi kaldır
                if (value.startsWith('TRTR')) {
                    value = 'TR' + value.substring(4);
                }

                // Sadece harf ve rakamları al
                value = value.replace(/[^A-Z0-9]/g, '');

                // TR kontrolü
                if (value.length >= 2 && value.substring(0, 2) !== 'TR') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: 'IBAN numarasını kontrol ediniz. TR ile başlamalı ve toplam 26 karakter olmalıdır.'
                    });
                    return '';
                }

                // Uzunluk kontrolü - tam 26 karakter olmalı
                if (value.length !== 26) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: 'IBAN numarasını kontrol ediniz. TR ile başlamalı ve toplam 26 karakter olmalıdır.'
                    });
                    return '';
                }

                // TR sonrası sadece rakam kontrolü
                if (value.length > 2) {
                    const numbersAfterTR = value.substring(2);
                    if (!/^\d+$/.test(numbersAfterTR)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: 'TR\'den sonraki karakterler sadece rakam olmalıdır!'
                        });
                        return '';
                    }
                }

                // IBAN'ı 4'lü gruplar halinde formatlama
                return value.replace(/(.{4})/g, '$1 ').trim();
            }

            function isValidIBAN(iban) {
                const ibanRegex = /^TR\d{24}$/;
                return ibanRegex.test(iban);
            }

            function formatIBAN(value) {
                // Sadece input sırasındaki temel formatlamalar
                value = value.toUpperCase().replace(/[^A-Z0-9]/g, '');

                // TRTR ile başlıyorsa düzelt
                if (value.startsWith('TRTR')) {
                    value = 'TR' + value.substring(4);
                }

                // Manuel yazım sırasında TR yerine rakamla başlıyorsa TR ekle
                if (value.length > 0 && /^\d/.test(value)) {
                    value = 'TR' + value;
                }

                // 26 karakterden uzunsa kes
                if (value.length > 26) {
                    value = value.substring(0, 26);
                }

                // 4'lü gruplar halinde formatla
                return value.replace(/(.{4})/g, '$1 ').trim();
            }

            ibanInput.addEventListener('input', function (e) {
                e.target.value = formatIBAN(e.target.value);
            });

            ibanInput.addEventListener('paste', function (e) {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                this.value = formatIBAN(pastedText);
            });

            ibanInput.addEventListener('blur', function () {
                const value = this.value.replace(/\s/g, '');
                if (value && !isValidIBAN(value)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: 'IBAN numarasını kontrol ediniz. TR ile başlamalı ve toplam 26 karakter olmalıdır.'
                    });
                    this.value = '';
                }
            });
        }


</script>

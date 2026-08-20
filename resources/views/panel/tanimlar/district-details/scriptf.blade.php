<script>



    $(document).ready(function() {
        function submitForm(redirectUrl = null) {
            // Form verilerini al
            let formData = {};

            // Tüm input, select ve textarea elemanlarını seç
            document.querySelectorAll(`#districtDetailForm input, #districtDetailForm select, #districtDetailForm textarea`).forEach(input => {
                formData[input.id] = input.value;
            });
            // AJAX isteği
            $.ajax({
                url: '{{route('update-district')}}',
                type: 'POST',
                data: {
                    formData : formData,
                    _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için

                },
                success: function(response) {
                    console.log(response);
                    iziToast.success({
                        title: 'İşlem Başarılı',
                        message: 'Bilgiler Guncellendi', // Assuming response.success contains the success message
                    });
                    // İşlem başarılıysa yönlendirme veya sayfada kalma
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    } else {
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);                        }
            });
        }

        // "Kaydet" butonuna tıklanınca
        $('#kaydetBtn').click(function() {
            submitForm();
        });

        // "Kaydet ve Kapat" butonuna tıklanınca
        $('#kaydetVeKapatBtn').click(function() {
            submitForm('/panel/Ilceler');
        });
    });

</script>
<script>
    // Select elemanlarını seç
    let ilNoSelect = document.getElementById('il_no');
    let ilNameSelect = document.getElementById('il_name_select');

    // İl No seçildiğinde İl Adını güncelle
    ilNoSelect.addEventListener('change', function() {
        let selectedIlNo = this.value;

        // İl Adı select elemanında, il_no'ya karşılık gelen name'i seç
        for (let i = 0; i < ilNameSelect.options.length; i++) {
            if (ilNameSelect.options[i].text === getProvinceNameByIlNo(selectedIlNo)) {
                ilNameSelect.selectedIndex = i;
                break;
            }
        }
    });

    // İl Adı seçildiğinde İl No'yu güncelle
    ilNameSelect.addEventListener('change', function() {
        let selectedIlName = this.value;

        // İl No select elemanında, name'e karşılık gelen il_no'yu seç
        for (let i = 0; i < ilNoSelect.options.length; i++) {
            if (ilNoSelect.options[i].value === getProvinceIlNoByName(selectedIlName)) {
                ilNoSelect.selectedIndex = i;
                break;
            }
        }
    });

    // İl No'ya göre İl Adı bulma fonksiyonu
    function getProvinceNameByIlNo(ilNo) {
        let provinces = @json($provinces);
        let province = provinces.find(p => p.il_no == ilNo);
        return province ? province.name : '';
    }

    // İl Adına göre İl No bulma fonksiyonu
    function getProvinceIlNoByName(name) {
        let provinces = @json($provinces);
        let province = provinces.find(p => p.name == name);
        return province ? province.il_no : '';
    }

</script>

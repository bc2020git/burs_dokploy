<script>
    $(document).ready(function() {
        function submitForm(redirectUrl = null) {
            // Form verilerini al
            let formData = {};

            // Tüm input, select ve textarea elemanlarını seç
            document.querySelectorAll(`#provinceDetailForm input, #provinceDetailForm select, #provinceDetailForm textarea`).forEach(input => {
                formData[input.id] = input.value;
            });
            // AJAX isteği
            $.ajax({
                url: '{{route('store-province')}}',
                type: 'POST',
                data: {
                    formData : formData,
                    _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için

                },
                success: function(response) {
                    console.log(response);
                    if(response.success){
                        iziToast.success({
                            title: 'İşlem Başarılı',
                            message: 'İşlem Başarılı', // Assuming response.success contains the success message
                        });
                    }
                    else{
                        iziToast.error({
                            title: 'İşlem Başarısız',
                            message: 'Plaka veya İl Adı Kayıtlı!', // Assuming response.success contains the success message
                        });
                    }
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
            submitForm('/panel/Iller');
        });
    });

</script>

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
                url: '{{route('update-province')}}',
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
            submitForm('/panel/Iller');
        });
    });

</script>

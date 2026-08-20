<script>


    $(document).ready(function() {
        function submitForm(redirectUrl = null) {
            // Form verilerini al
            let formData = {};
            var bankaAdiValue = document.getElementById('bankaAdi').value;
            var bankaKoduValue = document.getElementById('bankaKodu').value;
            formData['bankaAdi'] = bankaAdiValue;
            formData['bankaKodu'] = bankaKoduValue;

            // AJAX isteği
            $.ajax({
                url: '/panel/Banka-Ekle',
                type: 'POST',
                data: {
                    formData: formData,
                    _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için
                },
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        // Başarılı mesaj
                        iziToast.success({
                            title: 'İşlem Başarılı',
                            message: 'Banka Eklendi', // Assuming response.success contains the success message
                        });                        // İşlem başarılıysa yönlendirme veya sayfada kalma
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    }
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'İşlem Başarısız',
                        message: 'Ssitemde kayıtlı olan veriyi girdiniz. Yeni Kayıt Deneyiniz!', // Assuming response.success contains the success message
                    });
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);

                    // Hata durumunda toastr ile mesaj göster
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Bir hata oluştu.');
                    }
                }
            });
        }

        // "Kaydet" butonuna tıklanınca
        $('#kaydetBtn').click(function() {
            submitForm();
        });
        // "Kaydet ve Kapat" butonuna tıklanınca
        $('#kaydetVeKapatBtn').click(function() {
            submitForm('/panel/Bankalar');
        });
    });
</script>

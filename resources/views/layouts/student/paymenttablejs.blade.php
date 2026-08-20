<script>
$(document).ready(function() {
    // Sayfa yüklendiğinde tabloyu temizle
    $('#paymentTableBody').empty();

    // T.C Kimlik No. input'u değiştiğinde AJAX çağrısı yap
        var tcKimlikNo = $('#tc_no').val();
        loadPaymentInfo(tcKimlikNo);

    function loadPaymentInfo(tcKimlikNo) {
        $.ajax({
            url: '{{ route("get-payment-info") }}',
            type: 'GET',
            data: { tc_kimlik_no: tcKimlikNo },
            success: function(response) {
                $('#paymentTableBody').empty();
                $.each(response, function(index, bursOdeme) {
                    var row = `
                        <tr on style="cursor: pointer;" class="payment-row" data-id="${bursOdeme.id}"
                            ondblclick="window.location.href='{{ route('burs-odeme-duzenle', ['id' => ':id']) }}'.replace(':id', ${bursOdeme.id})">
                            <td>${bursOdeme.tc_kimlik_no}</td>
                            <td>${bursOdeme.burs_tipi}</td>
                            <td><span class='text-capitalize'>${bursOdeme.okul_tipi}</span></td>
                            <td>${bursOdeme.ad}</td>
                            <td>${bursOdeme.soyad}</td>
                            <td>${bursOdeme.donem}</td>
                            <td>${bursOdeme.iban}</td>
                            <td>${bursOdeme.bursveren}</td>
                            <td>${bursOdeme.burs_ayi}</td>
                            <td>${bursOdeme.odeme_periyodu}</td>
                            <td>${bursOdeme.odeme_tutari} TL</td>
                            <td>${bursOdeme.odeme_tarihi}</td>
                            <td>${bursOdeme.ogrenciye_burs_odeme_tarihi ? bursOdeme.ogrenciye_burs_odeme_tarihi : ''}</td>
                            <td>${bursOdeme.odeme_durumu === 'Odendi' ?
                                '<span class="badge bg-success">Ödendi</span>' :
                                bursOdeme.odeme_durumu === 'İptal Edildi' ?
                                '<span class="badge bg-danger">İptal Edildi</span>' :
                                '<span class="badge bg-warning">Beklemede</span>'
                            }</td>
                        </tr>
                    `;
                    $('#paymentTableBody').append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    window.loadPaymentInfoForScholar = loadPaymentInfo;

});
</script>



<script>
    function  checkleng(){
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        var length  = selectedCheckboxes.length;
        return length > 0;
    }
    $(document).ready(function() {

        function sendEmails() {
            // Seçili checkbox'ları bul
            const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
            var length  = selectedCheckboxes.length;
            console.log(length);
            // Seçili checkbox'ların e-posta adreslerini topla
            const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

            // E-posta adreslerini sunucuya gönder
            fetch('{{ route('send-emails') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
                },
                body: JSON.stringify({ emails: emailList })
            })
                .then(response => response.json())
                .then(data => {
                    window.location.href = data.redirectUrl;
                })
                .catch(error => {
                    console.error('Hata:', error);
                });
        }
        function sendSms() {
            // Seçili checkbox'ları bul
            const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
            var length = selectedCheckboxes.length;

            // Seçili checkbox'ların telefon numaralarını topla
            const telList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-tel'));

            // Telefon numaralarını sunucuya gönder
            fetch('{{ route('send-sms') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ tel: telList })
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = data.redirectUrl;
            })
            .catch(error => {
                console.error('Hata:', error);
            });
        }


        $('#createInterview').on('click', function() {
            if (!checkleng()){
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
            else{
                const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                var length  = selectedCheckboxes.length;
                if(length > 1){
                    const interviewWarningModal2 = new bootstrap.Modal(document.getElementById('interviewWarningModal2'));
                    interviewWarningModal2.show();

                }
                else{
                    const selectedUserIds = [];


                    // Checkbox'lar arasında işaretli olanları bul
                    const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                    // Eğer en az bir checkbox işaretli ise ilk elemanın 'data-id' değerini al
                    if (checkboxes.length > 0) {
                        const selectedUserId = checkboxes[0].getAttribute('data-id');

                        // 'mülakatadayid' inputunun value değerini bu ID olarak ayarla
                        const mulakatAdayIdInput = document.querySelector('input[name="mulakatadayid"]');
                        if (mulakatAdayIdInput) {
                            mulakatAdayIdInput.value = selectedUserId;
                        }
                    }
                    const interviewWarningModal = new bootstrap.Modal(document.getElementById('createInterviewModal'));
                    interviewWarningModal.show();
                }


            }
        });
        $('#search').on('click', function() {
            $('#candidateTable_filter label').toggleClass('d-none');
        });
        $('#mail').on('click', function() {
            if (checkleng()){
                sendEmails('redirectmultiplemail');
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
        $('#sms').on('click', function() {
            if (checkleng()){
                sendSms();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });




        $('#tcCheckbox').on('change', function() {
            var column = table.column(1); // Başvuru No sütunu
            column.visible($(this).is(':checked'));
        });
        $('#adCheckbox').on('change', function() {
            var column = table.column(2); // Ad sütunu
            column.visible($(this).is(':checked'));
        });
        $('#soyadCheckbox').on('change', function() {
            var column = table.column(3); // Soyad sütunu
            column.visible($(this).is(':checked'));
        });
        $('#puanCheckbox').on('change', function() {
            var column = table.column(4); // Başvuru Puanı sütunu
            column.visible($(this).is(':checked'));
        });
        $('#ogrenimCheckbox').on('change', function() {
            var column = table.column(5); // Öğrenim Türü sütunu
            column.visible($(this).is(':checked'));
        });
    });
</script>
<script>
    function adaySil() {
        // Seçili checkbox'ları bul
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        const isChecked = selectedCheckboxes.length;

        // Seçili checkbox'ların e-posta adreslerini topla
        const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

        // E-posta adreslerini sunucuya gönder
        fetch('/panel/Aday-Toplu-Sil', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
            },
            body: JSON.stringify({ emails: emailList })
        })
            .then(response => response.json())
            .then(data => {
                window.location.href = data.redirectUrl;
            })
            .catch(error => {
                console.error('Hata:', error);
            });
    }
</script>

<script>

    function selectAll(a){
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = a.checked;
        });

    }
    function islemIcinDiziGonder(islemid) {
        // Tüm checkbox'ları seç
        const selectedUserIds = [];
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

        // Her bir işaretli checkbox'ın 'data-id' değerini al
        checkboxes.forEach(checkbox => {
            const userId = checkbox.getAttribute('data-id');
            if (userId) {
                selectedUserIds.push(userId);
            }
        });
        console.log(selectedUserIds.length);
        // İşlem ID'sini belirle
        const islemId = islemid;

        // red durumundaki bilgileri ver
        const redSebebi = document.getElementById('redSebebi') ? document.getElementById('redSebebi').value : null;
        const digerAciklama = document.getElementById('digeraciklama') ? document.getElementById('digeraciklama').value : null;
        // iade durumundaki bilgileri ver
        const iadeSebebi = document.getElementById('iadeSebebi') ? document.getElementById('iadeSebebi').value : null;
        const iadeDigerAciklama = document.getElementById('iadeDigerAciklama') ? document.getElementById('iadeDigerAciklama').value : null;

        // Toplu mülakat atama işlemi için
        const mulakatAta = document.getElementById('mulakatAta') ? document.getElementById('mulakatAta').value : null;

        if (islemid === 4) {  // Toplu indirme işlemi için
            startChunkedExport(selectedUserIds);
            return;
        }

        if (islemId === 2) {
            const iadeSel = document.getElementById('iadeSebebi');
            if (!iadeSel || !String(iadeSel.value || '').trim()) {
                if (typeof toastr !== 'undefined') {
                    toastr.warning('Lütfen iade sebebini seçiniz.');
                } else {
                    alert('Lütfen iade sebebini seçiniz.');
                }

                return;
            }
        }

        function startChunkedExport(userIds) {
            $('#exportProgressModal').modal('show');
            $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
            $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

            $.ajax({
                url: '{{ route('aday.export.start') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userIds: JSON.stringify(userIds)
                },
                success: function(response) {
                    const exportId = response.exportId;
                    const total = response.total;
                    const batchSize = response.batchSize;
                    const totalChunks = Math.ceil(total / batchSize);
                    
                    if (total === 0) {
                        alert('Seçili kayıt bulunamadı.');
                        $('#exportProgressModal').modal('hide');
                        return;
                    }

                    processChunk(exportId, 0, totalChunks, batchSize, total);
                },
                error: function() {
                    alert('Export başlatılamadı.');
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function processChunk(exportId, index, totalChunks, batchSize, total) {
            if (index >= totalChunks) {
                finalizeExport(exportId, totalChunks);
                return;
            }

            const progress = Math.round((index / totalChunks) * 100);
            $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
            $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

            $.ajax({
                url: '{{ route('aday.export.chunk') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    index: index,
                    batchSize: batchSize
                },
                success: function() {
                    processChunk(exportId, index + 1, totalChunks, batchSize, total);
                },
                error: function() {
                    alert('Parça işlenirken hata oluştu.');
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function finalizeExport(exportId, totalChunks) {
            $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
            $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

            $.ajax({
                url: '{{ route('aday.export.finalize') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    totalChunks: totalChunks
                },
                success: function(response) {
                    $('#exportProgressStatus').text('Tamamlandı! İndiriliyor...');
                    setTimeout(function() {
                        $('#exportProgressModal').modal('hide');
                        window.location.href = response.downloadUrl;
                    }, 1000);
                },
                error: function() {
                    alert('Dosya oluşturulamadı.');
                    $('#exportProgressModal').modal('hide');
                }
            });
        }


        $.ajax({
            url: '{{route('panel_aday_toplu_islem')}}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                userIds: selectedUserIds,
                islemId: islemId,
                redSebebi: redSebebi,          // Red sebebi (null olabilir)
                digerAciklama: digerAciklama,   // Diğer açıklama (null olabilir)
                iadeSebebi: iadeSebebi,          // Red sebebi (null olabilir)
                iadeDigerAciklama: iadeDigerAciklama,   // Diğer açıklama (null olabilir)
                mulakatAta: mulakatAta
            },
            success: function(response) {
                if (typeof toastr !== 'undefined' && typeof $ !== 'undefined') {
                    toastr.success(response.message || 'İşlem Başarılı');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    // Fallback olarak alert kullan
                    alert(response.message || 'İşlem Başarılı');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                toastr.error(response.message || 'İşlem Başarısız');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }


    $(document).ready(function() {
        $('#mulakatAtaBtn').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const mulakatAtaModal = new bootstrap.Modal(document.getElementById('mulakatAtaModal'));
                mulakatAtaModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
        $('#denied').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                rejectModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
        $('#confirm').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const confirmModal = new bootstrap.Modal(document.getElementById('successModal'));
                confirmModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
    });
    $(document).ready(function() {
        $('#toReturn').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const missingDocumentModal = new bootstrap.Modal(document.getElementById('missingDocumentModal'));
                missingDocumentModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
    });
    $(document).ready(function() {
        $('#btndenied').click(function(e) {
            e.preventDefault();
            if (checkleng()){
                islemIcinDiziGonder(0);
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }

        });
    });
    $(document).ready(function() {
        $('#confirmbtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(1);
        });
    });
    $(document).ready(function() {
        $('#mulakatAtaOnayBtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(5);
        });
    });

    $(document).ready(function() {
        $('#toReturnbtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(2);
        });
    });

    $(document).ready(function() {
        $('#waste').click(function(e) {
            e.preventDefault();
            if (checkleng()){
                islemIcinDiziGonder(3);
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
        $('#reload').click(function(e) {
            location.reload();
        });
    });
    // Topbar'daki butonları bağlama

    function topluAktarExport() {
        const filters = typeof activeFilters !== 'undefined' ? activeFilters : {};

        $('#exportProgressModal').modal('show');
        $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
        $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

        $.ajax({
            url: '{{ route('aday.export.start') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                userIds: JSON.stringify([]),
                filters: JSON.stringify(filters)
            },
            success: function(response) {
                const exportId = response.exportId;
                const total = response.total;
                const batchSize = response.batchSize;
                const totalChunks = Math.ceil(total / batchSize);

                if (total === 0) {
                    toastr.warning('Aktarılacak kayıt bulunamadı.');
                    $('#exportProgressModal').modal('hide');
                    return;
                }

                topluAktarProcessChunk(exportId, 0, totalChunks, batchSize, total);
            },
            error: function() {
                toastr.error('Export başlatılamadı.');
                $('#exportProgressModal').modal('hide');
            }
        });
    }

    function topluAktarProcessChunk(exportId, index, totalChunks, batchSize, total) {
        if (index >= totalChunks) {
            topluAktarFinalizeExport(exportId, totalChunks);
            return;
        }

        const progress = Math.round((index / totalChunks) * 100);
        $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
        $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

        $.ajax({
            url: '{{ route('aday.export.chunk') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                exportId: exportId,
                index: index,
                batchSize: batchSize
            },
            success: function() {
                topluAktarProcessChunk(exportId, index + 1, totalChunks, batchSize, total);
            },
            error: function() {
                toastr.error('Parça işlenirken hata oluştu.');
                $('#exportProgressModal').modal('hide');
            }
        });
    }

    function topluAktarFinalizeExport(exportId, totalChunks) {
        $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
        $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

        $.ajax({
            url: '{{ route('aday.export.finalize') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                exportId: exportId,
                totalChunks: totalChunks
            },
            success: function(response) {
                $('#exportProgressStatus').text('Tamamlandı! İndiriliyor...');
                setTimeout(function() {
                    $('#exportProgressModal').modal('hide');
                    window.location.href = response.downloadUrl;
                }, 1000);
            },
            error: function() {
                toastr.error('Dosya oluşturulamadı.');
                $('#exportProgressModal').modal('hide');
            }
        });
    }

    $(document).ready(function() {
        $('#topluIndirBtn').click(function(e) {
            e.preventDefault();
            topluAktarExport();
        });
    });
$(document).ready(function() {
        $('#puanHesaplaBtn').click(function(e) {
            e.preventDefault();
            if (checkleng()){
                islemIcinDiziGonder(6);
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
    });


</script>


    <script>


document.addEventListener("DOMContentLoaded", function () {
  const confirmButton = document.getElementById("confirm");
  const confirmModal = new bootstrap.Modal(
    document.getElementById("confirmModal")
  );
  const toReturnButton = document.getElementById("toReturn");
  const toReturnModal = new bootstrap.Modal(
    document.getElementById("missingDocumentModal")
  );
  const rejectedButton = document.getElementById("denied");
  const rejectedModal = new bootstrap.Modal(
    document.getElementById("rejectModal")
  );

  confirmButton.addEventListener("click", function () {
    confirmModal.show();
    // setTimeout(function () {
    //   window.location.href = "/admin/graduate-scholar.html";
    // }, 3000);
  });

  toReturnButton.addEventListener("click", function () {
    toReturnModal.show();
    // setTimeout(function () {
    //   window.location.href = "/admin/graduate-scholar.html";
    // }, 5000);
  });

  rejectedButton.addEventListener("click", function () {
    rejectedModal.show();
    // setTimeout(function () {
    //   window.location.href = "/admin/graduate-scholar.html";
    // }, 5000);
  });
});

</script>
<script>
    document.getElementById('graduate').addEventListener('click', function () {

        if (!checkleng()){
            const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
            interviewWarningModal.show();
        }
        else{
            const graduateConfirmModal = new bootstrap.Modal(document.getElementById('graduateConfirmModal'));
            graduateConfirmModal.show();

        }
    });
    function  checkleng(){
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        var length  = selectedCheckboxes.length;
        return length > 0;
    }
    $(document).ready(function() {
        function sendEmails() {
            // Seçili checkbox'ları bul
            const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
            // Seçili checkbox'ların e-posta adreslerini topla
            const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

            // E-posta adreslerini sunucuya gönder
            fetch('/send-emails', {
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


        $('#reload').on('click', function() {
            location.reload();
        });

    });
</script>
<script>
    // Mezun et butonu için


    function adaySil() {
        // Seçili checkbox'ları bul
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
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


    //TABLO SIRALAMA
    function sortTable(columnIndex, order, type) {
        var table = document.querySelector("table");
        var rows = Array.from(table.rows).slice(1);

        rows.sort(function(a, b) {
            var cellA = a.cells[columnIndex].innerText.trim();
            var cellB = b.cells[columnIndex].innerText.trim();

            if (type === 'numeric') {
                cellA = parseInt(cellA);
                cellB = parseInt(cellB);
            } else if (type === 'status') {
                var statusOrder = {
                    "Onaylandı": 1,
                    "Mülakat Bekliyor": 2,
                    "Red Edildi": 3
                };
                cellA = statusOrder[cellA];
                cellB = statusOrder[cellB];
            } else {
                cellA = cellA.toLowerCase();
                cellB = cellB.toLowerCase();
            }

            if (cellA < cellB) {
                return order === 'asc' ? -1 : 1;
            }
            if (cellA > cellB) {
                return order === 'asc' ? 1 : -1;
            }
            return 0;
        });

        rows.forEach(function(row) {
            table.appendChild(row);
        });
    }
    function selectAll(a){
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = a.checked;
        });

    }
    function sendEmails() {
        // Seçili checkbox'ları bul
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        // Seçili checkbox'ların e-posta adreslerini topla
        const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

        // E-posta adreslerini sunucuya gönder
        fetch('/send-emails', {
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

    function startChunkedActiveBursiyerExport(userIds) {
        $('#exportProgressModal').modal('show');
        $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
        $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

        $.ajax({
            url: '{{ route('aktif.export.start') }}',
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

                processActiveBursiyerChunk(exportId, 0, totalChunks, batchSize, total);
            },
            error: function() {
                alert('Export başlatılamadı.');
                $('#exportProgressModal').modal('hide');
            }
        });
    }

    function processActiveBursiyerChunk(exportId, index, totalChunks, batchSize, total) {
        if (index >= totalChunks) {
            finalizeActiveBursiyerExport(exportId, totalChunks);
            return;
        }

        const progress = Math.round((index / totalChunks) * 100);
        $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
        $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

        $.ajax({
            url: '{{ route('aktif.export.chunk') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                exportId: exportId,
                index: index,
                batchSize: batchSize
            },
            success: function() {
                processActiveBursiyerChunk(exportId, index + 1, totalChunks, batchSize, total);
            },
            error: function(xhr) {
                var msg = 'Parça işlenirken hata oluştu.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    msg = xhr.responseJSON.error;
                }
                alert(msg);
                $('#exportProgressModal').modal('hide');
            }
        });
    }

    function finalizeActiveBursiyerExport(exportId, totalChunks) {
        $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
        $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

        $.ajax({
            url: '{{ route('aktif.export.finalize') }}',
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

    function islemIcinDiziGonder(islemid) {
        const selectedUserIds = [];
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

        checkboxes.forEach(checkbox => {
            const userId = checkbox.getAttribute('data-id');
            if (userId) {
                selectedUserIds.push(userId);
            }
        });

        if (islemid === 4) {
            startChunkedActiveBursiyerExport(selectedUserIds);

            return;
        }

        // Diğer işlemler için AJAX devam etsin
        $.ajax({
            url: '{{route('active_ky_toplu_islem')}}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                userIds: selectedUserIds,
                islemId: islemid,
                redSebebi: document.getElementById('redSebebi')?.value,
                digerAciklama: document.getElementById('digeraciklama')?.value,
                iadeSebebi: document.getElementById('iadeSebebi')?.value,
                iadeDigerAciklama: document.getElementById('iadeDigerAciklama')?.value,
                bursiyerTipi: document.getElementById('bursiyerTipiModalSelect')?.value
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.result === true) {
                    iziToast.success({
                        title: 'Başarılı',
                        message: response.message || 'İşlem başarıyla gerçekleştirildi.',
                        onClosing: function() {
                            location.reload();
                        }
                    });
                } else {
                    iziToast.error({
                        title: 'Hata',
                        message: 'İşlem başarısız oldu.',
                        onClosing: function() {
                            location.reload();
                        }
                    });
                    console.error('İşlem başarısız:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
                iziToast.error({
                    title: 'Hata',
                    message: 'İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.',
                    onClosing: function() {
                        location.reload();
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        $('#graduatebtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(1);
        });
    });
    $(document).ready(function() {
        $('#cancelbtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(0);
        });
        $('#bursiyerTipGuncelleOnayBtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(5);
        });
    });

    $(document).ready(function() {
        $('#btnreturn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(2);
        });
    });

    $(document).ready(function() {
        $('#waste').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(3);
        });
    });

    $(document).ready(function() {
        $('#topluIndirBtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(4);
        });
    });
    // Topbar'daki butonları bağlama
    //burs iptal modalı için
    document.getElementById('cancel').addEventListener('click', function () {
        if (!checkleng()){
            const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
            interviewWarningModal.show();
        }
        else{
            const cancelScholarshipModal = new bootstrap.Modal(document.getElementById('cancelScholarshipModal'));
            cancelScholarshipModal.show();
        }

    });
    //bursiyer Tipi güncelleme  modalı için
    document.getElementById('bursiyerTipGuncelle').addEventListener('click', function () {
        if (!checkleng()){
            const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
            interviewWarningModal.show();
        }
        else{
            const bursiyerTipGuncelleModal = new bootstrap.Modal(document.getElementById('bursiyerTipGuncelleModal'));
            bursiyerTipGuncelleModal.show();
        }

    });
</script>

<script>
    // Dropdown için Bootstrap initialization
    document.addEventListener('DOMContentLoaded', function() {


        // Export menü öğelerine tıklandığında
        document.querySelectorAll('#export-menu li').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.id;

                switch(action) {
                    case 'pdfButton':
                        // PDF export işlemi
                        break;
                    case 'excelButton':
                        // Excel export işlemi
                        break;
                    case 'csvButton':
                        // CSV export işlemi
                        break;
                    case 'topluIndirBtn':
                        // Toplu indirme işlemi
                        break;
                }

                exportDropdown.hide();
            });
        });
    });
</script>

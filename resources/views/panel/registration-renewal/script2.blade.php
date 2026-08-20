<script>
    document.addEventListener("DOMContentLoaded", function() {
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

        confirmButton.addEventListener("click", function() {
            confirmModal.show();
            // setTimeout(function () {
            //   window.location.href = "/admin/graduate-scholar.html";
            // }, 3000);
        });

        toReturnButton.addEventListener("click", function() {
            toReturnModal.show();
            // setTimeout(function () {
            //   window.location.href = "/admin/graduate-scholar.html";
            // }, 5000);
        });

        rejectedButton.addEventListener("click", function() {
            rejectedModal.show();
            // setTimeout(function () {
            //   window.location.href = "/admin/graduate-scholar.html";
            // }, 5000);
        });
    });
</script>
<script>
    function checkleng() {
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        var length = selectedCheckboxes.length;
        return length > 0;
    }

    function sendEmails() {
        // Seçili checkbox'ları bul
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        var length = selectedCheckboxes.length;
        // Seçili checkbox'ların e-posta adreslerini topla
        const emailList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-email'));

        // E-posta adreslerini sunucuya gönder
        fetch('/send-emails', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
                },
                body: JSON.stringify({
                    emails: emailList
                })
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
        const telList = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-phone'));

        // Telefon numaralarını sunucuya gönder
        fetch('{{ route('send-sms') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    tel: telList
                })
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = data.redirectUrl;
            })
            .catch(error => {
                console.error('Hata:', error);
            });
    }
    $('#mail').on('click', function() {
        if (checkleng()) {
            sendEmails('redirectmultiplemail');
        } else {
            const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
            interviewWarningModal.show();
        }
    });
    $('#sms').on('click', function() {
        if (checkleng()) {
            sendSms();
        } else {
            const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
            interviewWarningModal.show();
        }
    });
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('showModal') === 'true') {
            $('#applicationPeriodModal').modal('show');
        }
    });

    function selectAll(a) {
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = a.checked;
        });

    }
</script>

<script>
    function sortTable(column, order) {
        const table = document.getElementById("registrationRenewalTable");
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.querySelectorAll("tr"));

        rows.sort((a, b) => {
            const cellA = a.cells[column].innerText.toLowerCase();
            const cellB = b.cells[column].innerText.toLowerCase();

            if (order === 'asc') {
                return cellA > cellB ? 1 : cellA < cellB ? -1 : 0;
            } else {
                return cellA < cellB ? 1 : cellA > cellB ? -1 : 0;
            }
        });

        rows.forEach(row => tbody.appendChild(row));
    }
</script>
<script>
    function getDistricts(a, districtSelectId) {
        var cityId = a.options[a.selectedIndex].getAttribute('data-id');

        // AJAX çağrısı
        $.ajax({
            url: '/get-districts/' + cityId,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                var secinizoption = document.createElement('option');
                secinizoption.value = '';
                secinizoption.text = 'Seçiniz';
                districtSelect.appendChild(secinizoption);
                // Dönen ilçeleri select içerisine ekleme
                data.forEach(function(district) {
                    var option = document.createElement('option');
                    option.value = district.isim; // district.id ile değiştirilmiş ID değeri
                    option.text = district.isim; // district.isim ile ilçe ismi
                    districtSelect.appendChild(option);
                });
            }
        });
    }

    function islemIcinDiziGonder(islemid) {
        // Tüm checkbox'ları seç
        const selectedUserIds = [];
        const selectedUserExportIds = [];
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

        // Her bir işaretli checkbox'ın 'data-id' değerini al
        checkboxes.forEach(checkbox => {
            const userId = checkbox.getAttribute('data-id');
            if (userId) {
                selectedUserIds.push(userId);
            }
        });
        if (islemid === 4) {
            startRenewExportFlow();
            return;
        }
        // İşlem ID'sini belirle
        const islemId = islemid;

        // red durumundaki bilgileri ver
        const redSebebi = document.getElementById('redSebebi') ? document.getElementById('redSebebi').value : null;
        const digerAciklama = document.getElementById('digeraciklama') ? document.getElementById('digeraciklama')
            .value : null;
        // iade durumundaki bilgileri ver
        const iadeSebebi = document.getElementById('iadeSebebi') ? document.getElementById('iadeSebebi').value : null;
        const iadeDigerAciklama = document.getElementById('iadeDigerAciklama') ? document.getElementById(
            'iadeDigerAciklama').value : null;

        $.ajax({
            url: '{{ route('panel_ky_toplu_islem') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                userIds: selectedUserIds,
                islemId: islemId,
                redSebebi: redSebebi, // Red sebebi (null olabilir)
                digerAciklama: digerAciklama, // Diğer açıklama (null olabilir)
                iadeSebebi: iadeSebebi, // Red sebebi (null olabilir)
                iadeDigerAciklama: iadeDigerAciklama // Diğer açıklama (null olabilir)
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
                var errorMsg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'İşlem Başarısız';
                toastr.error(errorMsg);
                setTimeout(function() {
                    location.reload();
                }, 1000);
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    $(document).ready(function() {

        //ky-onayla butonu basilinca
        $('#confirm').click(function(e) {
            e.preventDefault();
            if (checkleng()) {
                const kySuccessModal = new bootstrap.Modal(document.getElementById('kySuccessModal'));
                kySuccessModal.show();
            } else {
                const interviewWarningModal = new bootstrap.Modal(document.getElementById(
                    'interviewWarningModal'));
                interviewWarningModal.show();
            }
        });


    });
    $(document).ready(function() {
        $('#reload').click(function(e) {
            location.reload();
        });
    });
    $(document).ready(function() {
        //ky-reddet butonu basilinca
        $('#denied').click(function(e) {
            e.preventDefault();
            if (checkleng()) {
                const kyRejectModal = new bootstrap.Modal(document.getElementById('kyRejectModal'));
                kyRejectModal.show();
            } else {
                const interviewWarningModal = new bootstrap.Modal(document.getElementById(
                    'interviewWarningModal'));
                interviewWarningModal.show();
            }
        });

        //ky reddet modeli gonderilince
        $('#kyDeniedbtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(0);
        });
    });

    $(document).ready(function() {
        $('#search').on('click', function() {
            $('#registrationRenewalTable_filter label').toggleClass('d-none');
        });
        //ky-iade butonu basilinca
        $('#toReturn').click(function(e) {
            e.preventDefault();
            if (checkleng()) {
                const kyMissingDocumentModal = new bootstrap.Modal(document.getElementById(
                    'kyMissingDocumentModal'));
                kyMissingDocumentModal.show();
            } else {
                const interviewWarningModal = new bootstrap.Modal(document.getElementById(
                    'interviewWarningModal'));
                interviewWarningModal.show();
            }
        });

        //ky iade modeli gonderilince
        $('#toReturnbtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(2);
        });
    });

    $(document).ready(function() {
        $('#btnreturn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(2);
        });
    });


    $(document).ready(function() {
        $('#wastebtn').click(function(e) {
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
    $(document).ready(function() {
        $('#sifreYenileBtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(5);
        });
    });

    $('#graduate').on('click', function() {
        if (checkleng()) {
            const graduateModal = new bootstrap.Modal(document.getElementById('graduateModal'));
            graduateModal.show();
        } else {
            const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
            interviewWarningModal.show();
        }
    });

    function startRenewExportFlow() {
        const selectedRows = $('input[name="userCheckbox"]:checked');
        let selectedIds = [];

        selectedRows.each(function() {
            const fid = $(this).data('export-id') || $(this).data('exportId');
            if (fid) {
                selectedIds.push(fid);
            }
        });

        const filters = typeof activeFilters !== 'undefined' ? activeFilters : {};

        $('#exportProgressModal').modal('show');
        updateExportProgress(0, 'Başlatılıyor...');

        $.ajax({
            url: "{{ route('renew.export.start') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                userIds: JSON.stringify(selectedIds),
                filters: JSON.stringify(filters),
                wideExport: true
            },
            success: function(response) {
                const total = response.total;
                if (!total || total < 1) {
                    if (typeof toastr !== 'undefined') {
                        toastr.warning('Aktarılacak kayıt bulunamadı.');
                    } else {
                        alert('Aktarılacak kayıt bulunamadı.');
                    }
                    $('#exportProgressModal').modal('hide');
                    return;
                }
                processExportChunks(response.exportId, 0, total, response.batchSize);
            },
            error: function(xhr) {
                $('#exportProgressModal').modal('hide');
                alert('İhracat başlatılamadı: ' + (xhr.responseJSON ? xhr.responseJSON.error : 'Bilinmeyen hata'));
            }
        });
    }

    function processExportChunks(exportId, chunkIndex, total, batchSize) {
        const totalChunks = Math.max(1, Math.ceil(total / batchSize));
        const progress = Math.round((chunkIndex / totalChunks) * 100);

        updateExportProgress(progress, `Parça ${chunkIndex + 1} / ${totalChunks} işleniyor...`);

        $.ajax({
            url: "{{ route('renew.export.chunk') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                exportId: exportId,
                chunkIndex: chunkIndex,
                batchSize: batchSize
            },
            success: function() {
                if (chunkIndex + 1 < totalChunks) {
                    processExportChunks(exportId, chunkIndex + 1, total, batchSize);
                } else {
                    finalizeExport(exportId, totalChunks);
                }
            },
            error: function(xhr) {
                $('#exportProgressModal').modal('hide');
                alert('Parça işlenirken hata oluştu: ' + (xhr.responseJSON ? xhr.responseJSON.error : 'Bilinmeyen hata'));
            }
        });
    }

    function finalizeExport(exportId, totalChunks) {
        updateExportProgress(100, 'Dosya oluşturuluyor...');

        $.ajax({
            url: "{{ route('renew.export.finalize') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                exportId: exportId,
                totalChunks: totalChunks
            },
            success: function(response) {
                updateExportProgress(100, 'Dosya hazır, indiriliyor...');
                setTimeout(function() {
                    $('#exportProgressModal').modal('hide');
                    window.location.href = response.downloadUrl;
                }, 1000);
            },
            error: function(xhr) {
                $('#exportProgressModal').modal('hide');
                alert('Dosya oluşturulamadı: ' + (xhr.responseJSON ? xhr.responseJSON.error : 'Bilinmeyen hata'));
            }
        });
    }

    function updateExportProgress(progress, status) {
        const bar = $('#exportProgressBar');
        bar.css('width', progress + '%');
        bar.attr('aria-valuenow', progress);
        bar.text(progress + '%');
        $('#exportProgressStatus').text(status);
    }
</script>

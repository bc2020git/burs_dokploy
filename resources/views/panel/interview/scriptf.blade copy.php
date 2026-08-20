<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('panel-basvuru-incele', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;

});

</script>
<script>
    $(document).ready(function() {
        let dtColumns = [
            // Checkbox sütununu güncelle
            {
                data: null,
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<input type="checkbox"
                        class="checkbox"
                        value="${row.id}"
                        data-id="${row.id}"
                        name="userCheckbox"
                        data-firstname="${row.name}"
                        data-lastname="${row.surname}"
                        data-phone="${row.tel_no}"
                        data-email="${row.email}">`;
                }
            }
        ];

        // Diğer sütunları ekle
        Object.values(columns).forEach(function(column) {
            let columnDef = {
                data: column.name,
                name: column.name,
                render: function(data, type, row) {
                    if (type === 'display') {
                        switch(column.name) {
                            case 'checkbox':
                                return data;
                            case 'aday.doc_fotograf':
                                if (data) {
                                    return `<img class="rounded-circle" src="{{url('')}}${data}" alt="Profil" style="width:50px; height:50px">`;
                                } else {
                                    return `<img class="rounded-circle" src="{{url('')}}/assets/images/default-profile.svg" alt="Profil" style="width:50px; height:50px">`;
                                }
                            case 'id':
                             return data;
                            case 'interview_result':
                                return getInterviewStatus(data);
                            case 'aday.educationType':
                                return getEducationType(data);
                            default:
                                return data;
                        }
                    }
                    return data;
                }
            };
            dtColumns.push(columnDef);
        });
        function getInterviewStatus(type){
            switch(type){
                case 'Planlandı': return `<span class="status-box-warning">Planlandı</span>`; break;
                case 'Olumlu': return `<span class="status-box-success">Olumlu</span>`; break;
                case 'Olumsuz': return `<span class="status-box-danger">Olumsuz</span>`; break;
                default: return `<span class="status-box-secondary">${type}</span>`;
            }
        }
        function getEducationType(type){
            switch(type){
                case 'ilkokul': return 'İlkokul'; break;
                case 'ortaokul': return 'Ortaokul'; break;
                case 'lise': return 'Lise'; break;
                case 'onlisans': return 'Ön Lisans'; break;
                case 'lisans': return 'Lisans'; break;
                case 'ylisans': return 'Yüksek Lisans'; break;
                case 'doktora': return 'Doktora'; break;
                default: return data;
            }
        }
        // İşlemler sütununu ekle
        dtColumns.push({
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                if (type === 'display') {
                    return `

                        <button class="btn edit-interview-btn" data-id="${row.id}" data-date="${row.interview_date}" data-time="${row.interview_time}" data-platform="${row.interview_platform}" data-person="${row.interview_person}" data-address="${row.interview_address}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"></path>
                            </svg>
                        </button>
                    `;
                }
                return '';
            }
        });


        // DataTable tanımlaması
        table = $('#interviewTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('mulakatlar.data') }}",
                data: function(d) {
                    d.filters = filters;
                    return d;
                }
            },
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('redirect-row cursor-pointer')
                    .attr('data-id', data.id);
            },
            columns: dtColumns,
            lengthMenu: [[10, 25, 50, 100 , 250 , 500], [10, 25, 50, 100 , 250 ,500]],
            pageLength: 10,
            ordering: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            orderCellsTop: true,
            order: [],
            initComplete: function() {
                // Tablo yüklendikten sonra sütun görünürlüklerini uygula
                loadColumnVisibility();
            },
            columnDefs: [
                {
                    targets: '_all',
                    orderable: false
                }
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                 buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible:not(:first-child)',
                        format: {
                            header: function(data, columnIdx) {
                                // Başlık metnini al
                                const title = $(data).find('.column-header').first().clone()    // Elementi klonla
                                    .children().remove()    // Tüm alt elementleri kaldır
                                    .end()     // Tekrar üst elemente dön
                                    .text()    // Text içeriğini al
                                    .trim();   // Boşlukları temizle
                                return title || $(data).text().trim(); // Eğer title boşsa, direkt text içeriğini al
                            }
                        },
                        rows: function(idx, data, node) {
                            const selectedRows = $('.checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.checkbox').prop('checked');
                            }
                            return true;
                        }
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:not(:first-child)',
                        format: {
                            header: function(data, columnIdx) {
                                const title = $(data).find('.column-header').first().clone()
                                    .children().remove()
                                    .end()
                                    .text()
                                    .trim();
                                return title || $(data).text().trim();
                            }
                        },
                        rows: function(idx, data, node) {
                            const selectedRows = $('.checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.checkbox').prop('checked');
                            }
                            return true;
                        }
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:not(:first-child)',
                        format: {
                            header: function(data, columnIdx) {
                                const title = $(data).find('.column-header').first().clone()
                                    .children().remove()
                                    .end()
                                    .text()
                                    .trim();
                                return title || $(data).text().trim();
                            }
                        },
                        rows: function(idx, data, node) {
                            const selectedRows = $('.checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.checkbox').prop('checked');
                            }
                            return true;
                        }
                    },charset: 'utf-8',
                    bom: true,
                    fieldSeparator: ';',  // Excel'de daha iyi görünmesi için
                    fieldBoundary: '"',   // Metin alanlarını çift tırnak içine al
                    escapeChar: '"'       // Kaçış karakteri
                }
            ],
            language: {
                url: 'https://datatables-cdn.com/plug-ins/2.1.8/i18n/tr.json',
                paginate: {
                previous: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                         '<path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"></path>' +
                         '</svg>',
                next: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                      '<path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"></path>' +
                      '</svg>'
            }},
        });
    });


 // Export butonları için event listener'lar
 $(document).ready(function() {
        // Excel export




        // CSV export
        $('#csvButton').on('click', function() {
            exportTable('csv');
        });

        // Export fonksiyonu
        function exportTable(type) {
            // Seçili satırları al
            const selectedRows = $('.checkbox:checked');
            const selectedIndexes = [];

            // Seçili satırların indexlerini topla
            if (selectedRows.length > 0) {
                selectedRows.each(function() {
                    const row = $(this).closest('tr');
                    const rowIdx = table.row(row).index();
                    selectedIndexes.push(rowIdx);
                });
            }

            // Export seçeneklerini ayarla
            const exportOptions = {
                columns: ':visible:not(:first-child)', // Checkbox sütununu hariç tut
                rows: function(idx, data, node) {
                    if (selectedRows.length > 0) {
                        return selectedIndexes.includes(idx);
                    }
                    return true;
                }
            };

            // Export işlemini gerçekleştir
            switch(type) {
                case 'excel':
                    table.button('.buttons-excel').trigger();
                    break;
                case 'pdf':
                    table.button('.buttons-pdf').trigger();
                    break;
                case 'csv':
                    table.button('.buttons-csv').trigger();
                    break;
            }
        }
    });

</script>
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


        $('#createInterview').on('click', function() {

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


        });




        $('#csvButton').on('click', function() {
            table.button('.buttons-csv').trigger();
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
    function islemIcinDiziGonder(islemid) {
        // Tüm checkbox'ları seç
        const selectedUserIds = [];
        const checkboxes = document.querySelectorAll('input[name="interviewCheckbox"]:checked');

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

        $.ajax({
            url: '/Mulakat-Toplu-Islem',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                userIds: selectedUserIds,
            },
            success: function(response) {
                console.log('Veriler gönderildi:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        $('#confirm').click(function(e) {
            e.preventDefault();

            if (checkleng()){
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            }
            else{
                const interviewWarningModal = new bootstrap.Modal(document.getElementById('interviewWarningModal'));
                interviewWarningModal.show();
            }
        });
    });
    $(document).ready(function() {
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
        $('#confirmbtnmodel').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(1);
        });
    });$(document).ready(function() {
        $('#confirmbtnmodel').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(1);
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



</script>

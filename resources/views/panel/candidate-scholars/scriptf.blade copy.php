<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('panel-basvuru-incele', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});


</script>
<script>






       // Dropdown'ların manuel olarak initialize edilmesi
       var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });



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
                            case 'doc_fotograf':
                                if (data) {
                                    return `<img class="rounded-circle" src="{{url('')}}${data}" alt="Profil" style="width:50px; height:50px">`;
                                } else {
                                    return `<img class="rounded-circle" src="{{url('')}}/assets/images/default-profile.svg" alt="Profil" style="width:50px; height:50px">`;
                                }
                            case 'id':
                             return data;
                            case 'mulakat_durumu':
                                switch(data) {
                                    case 'Mülakat Yapılacak': return '<span class="status-box-warning">Mülakat Yapılacak </span>'; break;
                                    case 'Planlandı': return '<span class="status-box-warning">Planlandı </span>'; break;
                                    case 'Olumlu': return '<span class="status-box-success">Olumlu </span>'; break;
                                    case 'Olumsuz': return '<span class="status-box-danger">Olumsuz </span>'; break;
                                    default: return data;
                                }
                            case 'educationType':
                                switch(data) {
                                    case 'ilkokul': return 'İlkokul'; break;
                                    case 'ortaokul': return 'Ortaokul'; break;
                                    case 'lise': return 'Lise'; break;
                                    case 'onlisans': return 'Ön Lisans'; break;
                                    case 'lisans': return 'Lisans'; break;
                                    case 'ylisans': return 'Yüksek Lisans'; break;
                                    case 'doktora': return 'Doktora'; break;
                                    default: return data;
                                }
                            case 'status':

                                switch(data) {
                                    case 0: return `<span class="status-box-warning">Devam Ediyor</span>`; break;
                                    case 1: return `<span class="status-box-warning">Onay Bekliyor</span>`; break;
                                    case 2: return `<span class="status-box-secondary">İade Edildi</span>`; break;
                                    case 3: return `<span class="status-box-success">Onaylandı</span>`; break;
                                    case 4: return `<span class="status-box-danger">Red Edildi</span>`; break;
                                    case 5: return `<span class="status-box-danger">İadeden Döndü</span>`; break;
                                    default: return `<span class="status-box-secondary">${data}</span>`;
                                }
                            case 'uye_statusu':
                                let statusClass = '';
                                switch(data) {
                                    case 'Üye': statusClass = 'uye'; break;
                                    case 'Aday': statusClass = 'aday'; break;
                                    case 'İptal': statusClass = 'iptal'; break;
                                    default: statusClass = 'secondary';
                                }
                                return ` <span class="status-circle status-circle-${statusClass}"> </span> ${data}`;
                            case column.name.startsWith('doc_') ? column.name : '':
                                if(data){
                                    return '<span class="status-box-success">Evet</span>';
                                }else{
                                    return '<span class="status-box-danger">Hayır</span>';
                                }
                            case 'uye_sistem_durumu':
                                let sistemClass = data === 'Etkin' ? 'active' : 'inactive';
                                return `<span class="system-status-circle system-status-${sistemClass}"></span> ${data}`;
                            case 'aidat_odeme':
                                let aidatClass = '';
                                switch(data) {
                                    case 'Başarılı': aidatClass = 'success'; break;
                                    case 'Ödeme Bekleniyor': aidatClass = 'warning'; break;
                                    case 'Ödeme Başarısız': aidatClass = 'danger'; break;
                                    default: aidatClass = 'secondary';
                                }
                                return `<span class="status-box-${aidatClass}">${data}</span>`;
                            default:
                                return data;
                        }
                    }
                    return data;
                }
            };
            dtColumns.push(columnDef);
        });

        // İşlemler sütununu ekle
        dtColumns.push({
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                var url = "{{ route('panel-basvuru-incele', ['id' => ':id']) }}".replace(':id', row.id);
                var smsUrl = "{{ route('send-sms', ['id' => ':id']) }}".replace(':id', row.id);
                var mailUrl = "{{ route('getScholarMailForm', ['eposta' => ':eposta']) }}".replace(':eposta', row.email);
                if (type === 'display') {
                    return `
                        <button class="btn btn-sm me-1 send-sms" onclick="sendSmsByButon(this)" data-id="${row.id}" data-phone="${row.tel_no}" data-name="${row.name}" data-surname="${row.surname}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#FFA800"/>
                            </svg>
                        </button>
                        <button class="btn btn-sm me-1 send-mail" onclick="location.href='${mailUrl}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#8353E2"/>
                            </svg>
                        </button>
                        <a href="${url}" class="btn btn-sm edit-member">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                            </svg>
                        </a>
                    `;
                }
                return '';
            }
        });

        // DataTable tanımlaması
        table = $('#candidateTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('aday.data') }}",
                data: function(d) {
                    d.filters = filters;
                    if (currentSort.column) {
                        d.order = [{
                            column: currentSort.column,
                            dir: currentSort.direction
                        }];
                    }
                    return d;
                },
                error: function (xhr, error, thrown) {
                    // Hata durumunda 3 kez yeniden deneme yap
                    let retryCount = 0;
                    const maxRetries = 3;
                    const retryDelay = 1000; // 1 saniye bekle

                    function retryAjax() {
                        if (retryCount < maxRetries) {
                            retryCount++;
                            setTimeout(function() {
                                table.ajax.reload(null, false); // false parametresi sayfayı aynı konumda tutar
                            }, retryDelay);
                        }
                    }

                    retryAjax();
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
            columnDefs: [
                {
                    targets: '_all',
                    orderable: false
                },
                {
                    // docColumns içindeki sütunları varsayılan olarak gizle
                    targets: getHiddenColumnIndexes(),
                    visible: false
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
                    orientation: 'landscape', // Yatay format
                    pageSize: 'A4', // Daha büyük sayfa boyutu
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
                    },
                    charset: 'utf-8',
                    bom: true,
                    fieldSeparator: ';',  // Excel'de daha iyi görünmesi için
                    fieldBoundary: '"',   // Metin alanlarını çift tırnak içine al
                    escapeChar: '"'       // Kaçış karakteri
                }
            ],
            language: {
                url: '{{url('')}}/public/build/js/dataTables/tr.json',

                paginate: {
                previous: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                         '<path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"></path>' +
                         '</svg>',
                next: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                      '<path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"></path>' +
                      '</svg>'
            }},
        });
        function getHiddenColumnIndexes() {
            let hiddenIndexes = [];
        let docColumns = {!! json_encode($docColumns) !!}; // PHP'den gelen docColumns dizisi

        // Tablo başlıklarını dolaş
        $('table:first thead th').each(function(index) {
            let columnName = $(this).data('column');
            console.log(columnName);
            // Eğer sütun adı docColumns içinde varsa ve doc_Diger değilse
            if (docColumns.includes(columnName) && columnName !== 'doc_Diger') {
                hiddenIndexes.push(index);
            }
            if(columnName === 'doc_Diger'){
                hiddenIndexes.push(index);
            }
        });

        return hiddenIndexes;
    }
    function getColumnIndexByName(columnName) {
        let index = -1;
        table.columns().every(function(i) {
            if ($(this.header()).data('column') === columnName) {
                index = i;
                return false; // döngüden çık
            }
        });
        return index;
    }
 // Export butonları için event listener'lar
 $(document).ready(function() {
    // Sütun görünürlük kontrolü için event listener
    $('.column-visibility').on('change', function() {
            let columnName = $(this).data('column');
            let columnIndex = getColumnIndexByName(columnName);
            let isVisible = $(this).prop('checked');

            if (columnIndex !== -1) {
                table.column(columnIndex).visible(isVisible);
            }
            });
        // Excel export
        $('#excelButton').on('click', function() {
            exportTable('excel');
        });
        // Word export
        $('#wordButton').on('click', function() {
            exportTable('word');
        });
        // PDF export
        $('#pdfButton').on('click', function() {
            exportTable('pdf');
        });

        // CSV export
        $('#csvButton').on('click', function() {
            exportTable('csv');
        });

        // Export fonksiyonu
        function exportTable(type) {
            // Seçili satırları al
            const selectedRows = $('.checkbox:checked');
            const selectedIndexes = [];

            // Sadece görünür sütunların başlıklarını al
            const visibleColumns = table.columns(':visible:not(:first-child)').header().map(function() {
                return $(this).find('.column-header').contents().first().text().trim();
            }).toArray();

            // Export seçeneklerini ayarla
            const exportOptions = {
                columns: ':visible:not(:first-child)', // Checkbox sütununu hariç tut
                rows: function(idx, data, node) {
                    const selectedRows = $('.checkbox:checked');
                    if (selectedRows.length > 0) {
                        return $(node).find('.checkbox').prop('checked');
                    }
                    return true;
                },
                format: {
                    header: function(data, columnIdx) {
                        return visibleColumns[columnIdx];
                    }
                }
            };

            // Export butonlarını yapılandır
            const buttonConfig = {
                extend: type,
                exportOptions: exportOptions,
                customize: function(doc) {
                    if (type === 'pdf') {
                        // PDF özelleştirmeleri
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                    }
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
            // Yeni bir form oluştur ve POST isteği gönder
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{route('panel_aday_toplu_islem')}}';

            // CSRF token ekle
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Diğer verileri ekle
            const userIdsInput = document.createElement('input');
            userIdsInput.type = 'hidden';
            userIdsInput.name = 'userIds';
            userIdsInput.value = JSON.stringify(selectedUserIds);
            form.appendChild(userIdsInput);

            const islemIdInput = document.createElement('input');
            islemIdInput.type = 'hidden';
            islemIdInput.name = 'islemId';
            islemIdInput.value = islemid;
            form.appendChild(islemIdInput);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
            return;
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
                console.log('Veriler gönderildi:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
                location.reload();

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

    $(document).ready(function() {
        $('#topluIndirBtn').click(function(e) {
            e.preventDefault();
            islemIcinDiziGonder(4);
        });
    });



</script>

<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('panel-basvuru-incele', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});

    let table;
    let activeFilters = {};
    let currentOrder = null;
    // Filtre ikonu güncelleme
    function updateFilterIcon(columnName, hasFilter) {
        const columnHeader = $(`.dropdown[data-column="${columnName}"]`);
        const filterIcon = columnHeader.find('svg[data-column="' + columnName + '"]');

        if (hasFilter) {
            filterIcon.show();
        } else {
            filterIcon.hide();
        }
    }

    $(document).ready(function() {


        table = $('#candidateTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("aday.data") }}',
                data: function(d) {
                    d.filters = JSON.stringify(activeFilters);
                    if (currentOrder) {
                        d.order = JSON.stringify(currentOrder);
                    }
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
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return '<input type="checkbox" name="userCheckbox" class="form-check-input user-checkbox" data-id="' + row.id + '">';
                    }
                },
                @foreach($columns as $key => $column)

                    @if($column['is_visible'])
                    @switch($key)
                        @case('mulakat_durumu')
                            {
                                data: 'mulakat_durumu',
                                name: 'mulakat_durumu',
                                orderable: false,
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        switch(data) {
                                            case 'Mülakat Yapılacak':
                                                return '<span class="status-box-warning">Mülakat Yapılacak</span>';
                                            case 'Planlandı':
                                                return '<span class="status-box-warning">Planlandı</span>';
                                            case 'Olumlu':
                                                return '<span class="status-box-success">Olumlu</span>';
                                            case 'Olumsuz':
                                                return '<span class="status-box-danger">Olumsuz</span>';
                                            default:
                                                return data;
                                        }
                                    }
                                    return data;
                                }
                            },
                        @break
                        @case('educationType')
                            {
                                data: 'educationType',
                                name: 'educationType',
                                orderable: false,
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        switch(data) {
                                            case 'ilkokul': return 'İlkokul'; break;
                                    case 'ortaokul': return 'Ortaokul'; break;
                                    case 'lise': return 'Lise'; break;
                                    case 'onlisans': return 'Ön Lisans'; break;
                                    case 'lisans': return 'Lisans'; break;
                                    case 'ylisans': return 'Yüksek Lisans'; break;
                                    case 'doktora': return 'Doktora'; break;
                                    default: return '';
                                        }
                                    }
                                }
                            },
                        @break
                        @case('doc_fotograf')
                            {
                                data: 'doc_fotograf',
                                name: 'doc_fotograf',
                                orderable: false,
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        if (data) {
                                            return `<img class="rounded-circle" src="{{url('')}}${data}" alt="Profil" style="width:50px; height:50px">`;
                                        } else {
                                            return `<img class="rounded-circle" src="{{url('')}}/assets/images/default-profile.svg" alt="Profil" style="width:50px; height:50px">`;
                                        }
                                    }
                                    return data;
                                }
                            },
                        @break
                        @case(str_starts_with($key, 'doc_') && $key !== 'doc_fotograf')
                            {
                                data: '{{ $key }}',
                                name: '{{ $key }}',
                                orderable: false,
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        if (data) {
                                            return '<span class="status-box-success">Evet</span>';
                                        } else {
                                            return '<span class="status-box-danger">Hayır</span>';
                                        }
                                    }
                                    return data;
                                }
                            },
                        @break
                        @case('status')
                            {
                                data: 'status',
                                name: 'status',
                                orderable: false,
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        switch(data) {
                                    case 0: return `<span class="status-box-warning">Devam Ediyor</span>`; break;
                                    case 1: return `<span class="status-box-warning">Onay Bekliyor</span>`; break;
                                    case 2: return `<span class="status-box-secondary">İade Edildi</span>`; break;
                                    case 3: return `<span class="status-box-success">Onaylandı</span>`; break;
                                    case 4: return `<span class="status-box-danger">Red Edildi</span>`; break;
                                    case 5: return `<span class="status-box-danger">İadeden Döndü</span>`; break;
                                    default: return `<span class="status-box-secondary">${data}</span>`;
                                }
                                    }
                                }
                            },
                        @break
                        @default
                            {
                                data: '{{ str_contains($key, ".") ? str_replace(".", "_", $key) : $key }}',
                                name: '{{ str_contains($key, ".") ? $key : "users.".$key }}',
                                orderable: false
                            },
                    @endswitch
                    @endif
                @endforeach
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            ordering: false,
            pageLength: 25,
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
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        });
        // Tüm checkbox'ları seçme/kaldırma
        $(document).on('change', '#select-all', function() {
                $('.user-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Tekil checkbox değişiminde header checkbox'ı güncelle
            $(document).on('change', '.user-checkbox', function() {
                const allChecked = $('.user-checkbox:checked').length === $('.user-checkbox').length;
                $('#select-all').prop('checked', allChecked);
            });
        // Sıralama butonları
        $('.sort-option').on('click', function() {
            const column = $(this).data('column');
            const order = $(this).data('order');

            // Aktif sıralama butonlarını temizle
            $('.sort-option').removeClass('active');
            $(this).addClass('active');

            currentOrder = {
                column: column,
                dir: order
            };
            $('.dropdown-menu').removeClass('show');

            table.draw();
        });

        // Filtre uygulama
        $('.apply-filter').on('click', function() {
            const column = $(this).data('column');
            const value = $(`.filter-value[data-column="${column}"]`).val();
            const condition = $(`.filter-condition[data-column="${column}"]`).val();
            // Checkbox'lar için
            const checkedBoxes = $(`.${column}-check:checked`).map(function() {
                        return $(this).val();
                    }).get();

            if (value || condition === 'empty' || condition === 'not_empty') {
                activeFilters[column] = {
                    value: value,
                    condition: condition
                };
            }
             else {
                delete activeFilters[column];
            }
            if (checkedBoxes.length > 0) {
                activeFilters[column] = {
                    value: checkedBoxes,
                    condition: 'in'
                };
            }
            $(`#${column.replace(/\./g, '_')}_clear_filter`).removeClass('d-none');
            $('.dropdown-menu').removeClass('show');
            updateFilterIcon(column, true);
            table.draw();
        });

        // Dropdown menünün dışına tıklandığında kapanmasını engelle
        $('.dropdown-menu').on('click', function(e) {
            e.stopPropagation();
        });



    });


    function clearColumnFilter(columnName, event = null) {
        if (!table) {
            console.error('DataTable henüz yüklenmedi');
            return;
        }

        // Event parametresi varsa, event propagation'ı durdur
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Filtre değerlerini temizle
        $(`.filter-value[data-column="${columnName}"]`).val('');
        $(`.filter-condition[data-column="${columnName}"]`).prop('selectedIndex', 0);

        // Checkbox'ları temizle
        $(`.${columnName}-check`).prop('checked', false);
        // "Tümünü Seç" checkbox'ını da temizle
        $(`#select_all_${columnName}`).prop('checked', false);

        // Temizle butonunu gizle
        $(`#${columnName.replace(/\./g, '_')}_clear_filter`).addClass('d-none');

        // Aktif filtreleri temizle
        delete activeFilters[columnName];

        // İkonu gizle
        updateFilterIcon(columnName, false);

        // Dropdown'ı kapat
        const dropdownMenu = $(`[data-column="${columnName}"]`).closest('.dropdown').find('.dropdown-menu');
        dropdownMenu.removeClass('show');

        // Tabloyu yenile
        table.draw();
    }
    $('[id^="select_all_"]').on('change', function() {
                const columnName = this.id.replace('select_all_', '');
                const isChecked = $(this).prop('checked');

                // Tüm ilgili checkbox'ları güncelle
                $(`.${columnName}-check`).prop('checked', isChecked);

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
        // Sütun görünürlük kontrolü için event listener
        $('.column-visibility').on('change', function() {
            let columnName = $(this).data('column');
            let columnIndex = getColumnIndexByName(columnName);
            let isVisible = $(this).prop('checked');

            if (columnIndex !== -1) {
                table.column(columnIndex).visible(isVisible);
            }
            });

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

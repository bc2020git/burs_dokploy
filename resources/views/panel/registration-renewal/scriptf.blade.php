<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('kayitYenilemeDetay', ['id' => ':id']) }}".replace(':id', candidateId);
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
                        value="${row.form_id}"
                        data-id="${row.form_id}"
                        name="userCheckbox"
                        data-firstname="${row.name}"
                        data-lastname="${row.surname}"
                        data-phone="${row.tel_no}"
                        data-email="${row.email}">`;
                }
            }
        ];
        function getNestedValue(obj, path) {
            return path.split('.').reduce((current, key) =>
                current ? current[key] : '', obj);
        }
        // Diğer sütunları ekle
        Object.values(columns).forEach(function(column) {
            if (column.visible === false) {
                return;
            }
            let columnDef = {
                data: null,
                name: column.name,
                render: function(data, type, row) {
                    console.log(row);
                    if (type === 'display' && column.visible === true) {
                        switch(column.name) {
                            case 'checkbox':
                                return data;
                            case 'scholar.id':
                                return row.bursiyer_id;
                            case 'doc_fotograf':
                                if (row.doc_fotograf) {
                                    return `<img class="rounded-circle" src="{{url('')}}${row.doc_fotograf}" alt="Profil" style="width:50px; height:50px">`;
                                } else {
                                    return `<img class="rounded-circle" src="{{url('')}}/assets/images/default-profile.svg" alt="Profil" style="width:50px; height:50px">`;
                                }
                            case 'form.scholar.id':
                                return row.form ? (row.form.scholar ? row.form.scholar.id : '') : '';
                            case 'form.scholar.aday_id':
                                return row.form ? (row.form.scholar ? row.form.scholar.aday_id : '') : '';
                            case 'form.status':
                                return row.form ? row.form.status : '';
                            case 'status':
                                return getStatus(row.status);
                            case 'educationType':
                                return getEducationType(row.educationType);
                                case column.name.startsWith('doc_') ? column.name : '':
                                return getDocField(row[column.name]);
                            case 'p_school_name':
                                // Okul adı için koşullu gösterim
                                switch(row.educationType) {
                                    case 'ilkokul':
                                        return row.p_school_name || '';
                                    case 'ortaokul':
                                        return row.m_school_name || '';
                                    case 'lise':
                                        return row.h_school_name || '';
                                    default:
                                        return row.current_university || '';
                                }
                            case 'class':
                                // Sınıf için koşullu gösterim
                                const basicEducationTypes = ['ilkokul', 'ortaokul', 'lise'];
                                return basicEducationTypes.includes(row.educationType)
                                    ? (row.class || '')
                                    : (row.university_class || '');
                            default:
                                if (column.name.includes('.')) {
                                    return getNestedValue(row, column.name);
                                }
                                return row[column.name] || '';
                        }
                    }
                    return data;
                }
            };
            dtColumns.push(columnDef);
        });
        function getDocField(field){
            if(field){
                return '<span class="status-box-success">Evet</span>';
            } else {
                return '<span class="status-box-danger">Hayır</span>';
            }
        }
        function getStatus(status){
            switch(status){
                case 0: return '<span class="status-box-warning">Devam Ediyor</span>'; break;
                case 1: return '<span class="status-box-warning">Onay Bekliyor</span>'; break;
                case 2: return '<span class="status-box-secondary">İade Edildi</span>'; break;
                case 3: return '<span class="status-box-success">Onaylandı</span>'; break;
                case 4: return '<span class="status-box-danger">Reddedildi</span>'; break;
                case 5: return '<span class="status-box-warning">İadeden Döndü</span>'; break;
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
                default: return '';
            }
        }
        // İşlemler sütununu ekle
        dtColumns.push({
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                var smsUrl = "{{ route('send-sms', ['id' => ':id']) }}".replace(':id', row.id);
                var mailUrl = "{{ route('getScholarMailForm', ['eposta' => ':eposta']) }}".replace(':eposta', row.email);
                var url = "{{ route('kayitYenilemeDetay', ['id' => ':id']) }}".replace(':id', row.form_id);
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


        // Kolon görünürlüğü için state yönetimi
        let columnVisibility = {};

        // LocalStorage'dan kayıtlı durumu yükle
        function loadSavedColumnState() {
            const savedState = localStorage.getItem('registrationRenewalColumnVisibility');
            console.log('Kayıtlı durum:', savedState);
            if (savedState) {
                columnVisibility = JSON.parse(savedState);
                // Kayıtlı durumu uygula
                Object.entries(columnVisibility).forEach(([columnName, isVisible]) => {
                    toggleColumnVisibility(columnName, isVisible);
                    // Checkbox'ları güncelle
                    $(`.column-visibility[data-column="${columnName}"]`).prop('checked', isVisible);
                });
            }
        }

        // Kolon görünürlüğünü değiştir
        function toggleColumnVisibility(columnName, isVisible) {
            const columnIndex = getColumnIndexByName(columnName);
            if (columnIndex !== -1) {
                table.column(columnIndex).visible(isVisible);
                // State'i güncelle
                columnVisibility[columnName] = isVisible;
                // LocalStorage'a kaydet
                localStorage.setItem('registrationRenewalColumnVisibility', JSON.stringify(columnVisibility));
            }
        }

        // Sütun adına göre index bul
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

        // Checkbox event listener'ları
        $(document).on('change', '.column-visibility', function() {
            const columnName = $(this).data('column');
            const isVisible = $(this).prop('checked');
            toggleColumnVisibility(columnName, isVisible);
        });

        // DataTable tanımlamasından sonra kayıtlı durumu yükle
        table = $('#registrationRenewalTable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route('kayityenileme.data') }}",
                data: function(d) {
                    d.filters = filters;
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
                $(row).addClass('redirect-row cursor-pointer ')
                    .attr('data-id', data.form_id);
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
                    pageSize: 'A3', // Daha büyük sayfa boyutu
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
                        }
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
            initComplete: function() {
                loadSavedColumnState();
            }
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
  // Export butonları için event listener'lar
  $(document).ready(function() {
        // Excel export
        $('#excelButton').on('click', function() {
            startRenewExportFlow();
        });

        // PDF export
        $('#pdfButton').on('click', function() {
            exportTable('pdf');
        });

        // CSV export
        $('#csvButton').on('click', function() {
            exportTable('csv');
        });

        function startRenewExportFlow() {
            const selectedRows = $('.checkbox:checked');
            let selectedIds = [];

            if (selectedRows.length > 0) {
                selectedRows.each(function() {
                    selectedIds.push($(this).val());
                });
            } else {
                // Eğer hiçbir şey seçilmediyse tümünü ihraç etmek isteyebilir
                // Ancak sistem genellikle seçili olanlar üzerinde çalışıyor.
                // Burada bir uyarı gösterebiliriz veya tüm ID'leri çekebiliriz.
                // Mevcut yapıda adaylar sayfasındaki gibi tüm filtrelenmişleri çekelim.
                if (confirm('Hiçbir kayıt seçmediniz. Filtrelenmiş tüm kayıtlar ihraç edilsin mi?')) {
                    // Tümünü çekmek için sunucuya istek atılabilir veya DataTables'dan alınabilir.
                    // Şimdilik sadece seçili olanlar için yapalım, eğer boşsa uyarı verelim.
                    alert('Lütfen ihraç etmek istediğiniz kayıtları seçiniz.');
                    return;
                }
            }

            $('#exportProgressModal').modal('show');
            updateExportProgress(0, 'Başlatılıyor...');

            $.ajax({
                url: "{{ route('renew.export.start') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    ids: selectedIds
                },
                success: function(response) {
                    processExportChunks(response.exportId, 0, response.total, response.batchSize);
                },
                error: function(xhr) {
                    $('#exportProgressModal').modal('hide');
                    alert('İhracat başlatılamadı: ' + (xhr.responseJSON.error || 'Bilinmeyen hata'));
                }
            });
        }

        function processExportChunks(exportId, chunkIndex, total, batchSize) {
            const totalChunks = Math.ceil(total / batchSize);
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
                    alert('Parça işlenirken hata oluştu: ' + (xhr.responseJSON.error || 'Bilinmeyen hata'));
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
                    alert('Dosya oluşturulamadı: ' + (xhr.responseJSON.error || 'Bilinmeyen hata'));
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




    });

</script>

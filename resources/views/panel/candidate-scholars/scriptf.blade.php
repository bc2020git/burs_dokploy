<script>


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


        table = $('#{{$tableId}}').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: '{{$dataurl}}',
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
            {{$tableColumns}}
            columns: [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        return '<input type="checkbox" name="userCheckbox" class="form-check-input user-checkbox checkbox" data-id="' + row.id + '">';
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
                                    case 'yukseklisans': return 'Yüksek Lisans'; break;
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
                                    case 4: return `<span class="status-box-danger">Reddedildi</span>`; break;
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
                            const selectedRows = $('.user-checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.user-checkbox').prop('checked');
                            }
                            return selectedRows.length === 0; // Hiç seçim yoksa tüm satırları al
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
                            const selectedRows = $('.user-checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.user-checkbox').prop('checked');
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
                            const selectedRows = $('.user-checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.user-checkbox').prop('checked');
                            }
                            return selectedRows.length === 0; // Hiç seçim yoksa tüm satırları al
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
            initComplete: function(settings, json) {
                this.api().columns().every(function() {
                    let column = this;
                    let columnName = $(column.header()).data('column');
                    if (columnName) {
                        $(`.column-visibility[data-column="${columnName}"]`).prop('checked', column.visible());
                    }
                });
            }
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
            excelServerExport();
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

        // Excel sunucu taraflı export fonksiyonu (tüm veriyi aktarır)
        function excelServerExport() {
            // Seçili satırları al
            const selectedRows = $('.user-checkbox:checked');
            const selectedIds = [];
            selectedRows.each(function() {
                const id = $(this).data('id') || $(this).val();
                if (id) selectedIds.push(id);
            });

            // Görünür sütunları al (colvis checkbox'larından)
            const visibleColumns = [];
            $('.column-visibility:checked').each(function() {
                visibleColumns.push($(this).data('column'));
            });

            // Aktif filtreleri al (global activeFilters değişkeninden)
            const filters = typeof activeFilters !== 'undefined' ? activeFilters : {};

            // DataTables search değerini de filtre olarak ekle
            const searchValue = table.search();

            $('#exportProgressModal').modal('show');
            $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
            $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

            $.ajax({
                url: '{{ route("aday.export.start") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userIds: selectedIds.length > 0 ? JSON.stringify(selectedIds) : JSON.stringify([]),
                    filters: JSON.stringify(filters),
                    visibleColumns: JSON.stringify(visibleColumns)
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

                    excelProcessChunk(exportId, 0, totalChunks, batchSize, total);
                },
                error: function() {
                    toastr.error('Export başlatılamadı.');
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelProcessChunk(exportId, index, totalChunks, batchSize, total) {
            if (index >= totalChunks) {
                excelFinalizeExport(exportId, totalChunks);
                return;
            }

            const progress = Math.round((index / totalChunks) * 100);
            $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
            $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

            $.ajax({
                url: '{{ route("aday.export.chunk") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    index: index,
                    batchSize: batchSize
                },
                success: function() {
                    excelProcessChunk(exportId, index + 1, totalChunks, batchSize, total);
                },
                error: function() {
                    toastr.error('Parça işlenirken hata oluştu.');
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelFinalizeExport(exportId, totalChunks) {
            $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
            $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

            $.ajax({
                url: '{{ route("aday.export.finalize") }}',
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

        // Export fonksiyonu (PDF, CSV, Word için)
        function exportTable(type) {
            // Seçili satırları al
            const selectedRows = $('.user-checkbox:checked');
            const selectedIndexes = [];

            // Sadece görünür sütunların başlıklarını al
            const visibleColumns = table.columns(':visible:not(:first-child)').header().map(function() {
                return $(this).find('.column-header').contents().first().text().trim();
            }).toArray();

            // Export seçeneklerini ayarla
            const exportOptions = {
                columns: ':visible:not(:first-child)', // Checkbox sütununu hariç tut
                rows: function(idx, data, node) {
                    const selectedRows = $('.user-checkbox:checked');
                    if (selectedRows.length > 0) {
                        return $(node).find('.user-checkbox').prop('checked');
                    }
                    return selectedRows.length === 0; // Hiç seçim yoksa tüm satırları al
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

                        // PDF özelleştirmeleri
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                }
            };

            // Export işlemini gerçekleştir
            switch(type) {
                case 'pdf':
                    table.button('.buttons-pdf').trigger();
                    break;
                case 'csv':
                    table.button('.buttons-csv').trigger();
                    break;
            }
        }
    </script>


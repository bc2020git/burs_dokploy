<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('data-import.details', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});
$('#reload').on('click', function(e) {
    location.reload();
});
</script>
<script>
    $(document).ready(function() {
        $('#export').on('click', function(e) {
            e.preventDefault();
            $('#export-menu').toggleClass('show');
        });

    });
    $('#search').on('click', function() {
            $('#paymentInfoTable_filter label').toggleClass('d-none');
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
                        data-firstname="${row.ad}"
                        data-lastname="${row.soyad}"
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
                            case 'created_at':
                                return row.created_at ? moment(row.created_at).format('DD.MM.YYYY') : '';
                            default:
                                return row[column.name] ;
                        }
                    }
                    return data;
                }
            };
            dtColumns.push(columnDef);
        });

        function getStatus(status){
            switch(status){
                case 'Odendi': return '<span class="badge bg-success">Ödendi</span>'; break;
                case 'Beklemede': return '<span class="badge bg-warning">Beklemede</span>'; break;


            }
        }
        function getEducationType(type){
            switch(type){
                case 'ilkokul': return 'İlkokul'; break;
                case 'ortaokul': return 'Ortaokul'; break;
                case 'lise': return 'Lise'; break;
                case 'onlisans': return 'Ön Lisans'; break;
                case 'lisans': return 'Lisans'; break;
                case 'yukseklisans': return 'Yüksek Lisans'; break;
                case 'doktora': return 'Doktora'; break;
                default: return type;
            }
        }
        // İşlemler sütununu ekle
        dtColumns.push({
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                var url = "{{ route('data-import.delete', ['id' => ':id']) }}".replace(':id', row.id);
                var url2 = "{{ route('data-import.details', ['id' => ':id']) }}".replace(':id', row.id);
                if (type === 'display') {
                    return `
                        <a href='${url2}'>
                            <button class="btn btn-sm btn-color-blue">
                                <i class="fas fa-eye"></i>
                            </button>
                        </a>
                        <a href="${url}" class="btn btn-sm btn-color-red  edit-member">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M14.168 5.00033H18.3346V6.66699H16.668V17.5003C16.668 17.9606 16.2949 18.3337 15.8346 18.3337H4.16797C3.70774 18.3337 3.33464 17.9606 3.33464 17.5003V6.66699H1.66797V5.00033H5.83464V2.50033C5.83464 2.04009 6.20774 1.66699 6.66797 1.66699H13.3346C13.7949 1.66699 14.168 2.04009 14.168 2.50033V5.00033ZM7.5013 9.16699V14.167H9.16797V9.16699H7.5013ZM10.8346 9.16699V14.167H12.5013V9.16699H10.8346ZM7.5013 3.33366V5.00033H12.5013V3.33366H7.5013Z" fill="#4069E5"></path>
                                </svg>
                        </a>
                    `;
                }
                return '';
            }
        });
        // DataTable tanımlaması
        table = $('#paymentInfoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('data-import.data') }}",
                type: 'GET',
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
                $(row).addClass('redirect-row cursor-pointer ')
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
                ,charset: 'utf-8',
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
 // Export butonları için event listener'lar
 $(document).ready(function() {
        // Excel export
        $('#excelButton').on('click', function() {
            exportTable('excel');
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

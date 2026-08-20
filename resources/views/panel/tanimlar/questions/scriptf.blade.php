<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('panel-soru-detay', ['id' => ':id']) }}".replace(':id', candidateId);
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
                    if (type === 'display' && column.visible === true) {
                        switch(column.name) {
                            case 'checkbox':
                                return data;
                            case 'doc_fotograf':
                                if (row['doc_fotograf']) {
                                    return `<img class="rounded-circle" src="{{url('')}}${row['doc_fotograf']}" alt="Profil" style="width:50px; height:50px">`;
                                } else {
                                    return `<img class="rounded-circle" src="{{url('')}}/assets/images/default-profile.svg" alt="Profil" style="width:50px; height:50px">`;
                                }


                            case 'status':
                                return getStatus(row[column.name]);

                            case 'has_conditions':
                                return getHasConditions(row[column.name]);

                            default:
                                if (column.name.includes('.')) {
                                    return getNestedValue(row, column.name) || '';
                                }
                                return row[column.name] || '';
                        }
                    }
                    return data;
                }
            };
            dtColumns.push(columnDef);
        });
        function getStatus(value) {
            if ( value === 'Aktif') {
                return '<span class="status-box-success">Aktif</span>';
            } else if (value === 'Pasif') {
                return '<span class="status-box-danger">Pasif</span>';
            }
            return '';
        }
        function getHasConditions(value) {
            if ( value === 1 || value === '1' || value === true) {
                return '<span class="status-box-success">Evet</span>';
            } else {
                return '<span class="status-box-danger">Hayır</span>';
            }
        }
        function getType(item) {
                if(item == 'Vakıf') return '<span class="status-box-vakif">Vakıf</span>';
                if(item == 'Devlet') return '<span class="status-box-devlet">Devlet</span>';
                return '';
        }
        // İşlemler sütununu ekle
        dtColumns.push({
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                var url = "{{ route('panel-soru-detay', ['id' => ':id']) }}".replace(':id', row.id);
                if (type === 'display') {
                    return `

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
            stateSave: true,
            ajax: {
                url: "{{ route('form-sorulari.data') }}",
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
          lengthMenu: "Göster _MENU_ kayıt",
          zeroRecords: "Kayıt bulunamadı",
          info: "  _END_ öğeden _TOTAL_ 'i",
          infoEmpty: "Gösterilecek kayıt yok",
          infoFiltered: "(_MAX_ kayıt içinde filtrelendi)",
          search: "Ara:",
          paginate: {
              first: "İlk",
              last: "Son",
              next: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                  <path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"/>
              </svg>`,
              previous: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                  <path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"/>
              </svg>`,
          },
      },
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

<script>


    $(document).ready(function() {
        let columns = @json($columns);

        var filters = {};
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
                        >`;
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
                        case 'frontend_date':
                        case 'backend_date':
                            return data ? moment(data).format('DD.MM.YYYY') : '';
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

                if (type === 'display') {
                    const previewUrl =  "{{ route('versions.edit', ['id' => ':id']) }}".replace(':id', row.id);

                    return `
                        <svg
                            onclick="location.href='${previewUrl}'"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            data-bs-toogle="tooltip"
                            title="İncele"
                            style="cursor: pointer;"
                        >
                            <path d="M12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3ZM12.0003 19C16.2359 19 19.8603 16.052 20.7777 12C19.8603 7.94803 16.2359 5 12.0003 5C7.7646 5 4.14022 7.94803 3.22278 12C4.14022 16.052 7.7646 19 12.0003 19ZM12.0003 16.5C9.51498 16.5 7.50026 14.4853 7.50026 12C7.50026 9.51472 9.51498 7.5 12.0003 7.5C14.4855 7.5 16.5003 9.51472 16.5003 12C16.5003 14.4853 14.4855 16.5 12.0003 16.5ZM12.0003 14.5C13.381 14.5 14.5003 13.3807 14.5003 12C14.5003 10.6193 13.381 9.5 12.0003 9.5C10.6196 9.5 9.50026 10.6193 9.50026 12C9.50026 13.3807 10.6196 14.5 12.0003 14.5Z" fill="#636363"/>
                        </svg>
                    `;
                }
                return '';
            }
        });
        console.log(dtColumns);


        // Filtre durumunu güncelleme fonksiyonu
        function updateFilterIcon(columnName, hasFilter) {
            const columnHeader = $(`.column-header[data-column="${columnName}"]`);
            const filterIcon = columnHeader.find('.filter-active-icon');

            if (hasFilter) {
                filterIcon.show();
            } else {
                filterIcon.hide();
            }
        }




        // DataTable tanımlaması
        let retryCount = 0;
        const maxRetries = 3;
        initializeDataTable('#membershipTable', {
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('versions.data') }}",
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: function(d) {
                    d.filters = window.filters;
                    return d;
                },
                error: function(xhr, error, thrown) {


                    function retry() {
                        if (retryCount < maxRetries) {
                            retryCount++;
                            console.log(`Bağlantı hatası. ${retryCount}. deneme yapılıyor...`);
                            $.ajax(this);
                        } else {
                            console.error('DataTables hatası:', error, thrown);
                            window.location.reload();
                        }
                    }

                    retry();
                }
            },
            columns: dtColumns,
            lengthMenu: [[10, 25, 50, 100 , 250 , 500], [10, 25, 50, 100 , 250 ,500]],
            pageLength: 10,
            ordering: true,
            orderCellsTop: true,
            order: [],
            columnDefs: [
                {
                    targets: '_all',
                    orderable: false
                }
            ],
            dom: '<"row"<"col-sm-12 col-md-4"l><"col-sm-12 col-md-4"B><"col-sm-12 col-md-4"f>>rtip',
            buttons: [
                {
                    extend: 'collection',
                    text: '<i class="fas fa-download"></i> Dışa Aktar',
                    className: 'btn btn-primary',
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i> Excel',
                            className: 'btn btn-success',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="fas fa-file-pdf"></i> PDF',
                            className: 'btn btn-danger',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fas fa-file-csv"></i> CSV',
                            className: 'btn btn-info',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }

                    ]
                }
            ],
            language: {
                url: '{{url('')}}/public/assets/js/dataTables/tr.json',
                paginate: {
                previous: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                         '<path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"></path>' +
                         '</svg>',
                next: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                      '<path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"></path>' +
                      '</svg>'
            }},
        });

        // "Tümünü Seç/Kaldır" işlevselliği
        $('[id^="select_all_"]').on('change', function() {
            const columnName = this.id.replace('select_all_', '');
            const isChecked = $(this).prop('checked');

            $(`.${columnName}-check`).prop('checked', isChecked).trigger('change');
        });



        // Dropdown menünün kapanmasını engelle
        $(document).on('click', '.dropdown-menu', function(e) {
            e.stopPropagation();
        });

        // Başlangıçta tüm filtre ikonlarını gizle
        $('.filter-active-icon').hide();


        function sortColumn(column, direction) {
            // Sütun indeksini bul
            let columnIndex = -1;
            table.columns().every(function(index) {
                if (this.dataSrc() === column) {
                    columnIndex = index;
                    return false; // döngüyü durdur
                }
            });

            if (columnIndex !== -1) {
                // Sıralama yap ve tabloyu yenile
                table.order([columnIndex, direction]).draw();
            }
        }


        // Tümünü seç/kaldır checkbox'ı
        $('#masterCheckbox').change(function() {
            $('.checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>

<script>
@php
    $bursiyerServerExcelExport = $bursiyerServerExcelExport ?? false;
    $renewServerExcelExport = $renewServerExcelExport ?? false;
    $mezunServerExcelExport = $mezunServerExcelExport ?? false;
@endphp

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

        // Currently selected dynamic question columns
        function getSelectedDynamicColumns() {
            const cols = [];
            $('.question-column:checked').each(function() {
                cols.push({
                    data: $(this).data('column'),
                    title: $(this).data('title') || $(this).data('column')
                });
            });
            return cols;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Keep the <thead> in sync with the selected dynamic columns
        function syncDynamicHeaders() {
            const $headRow = $('#{{$tableId}} thead tr');
            $headRow.find('th.dynamic-th').remove();
            const $actionTh = $headRow.find('th').last();
            getSelectedDynamicColumns().forEach(function(c) {
                const colKey = c.data;
                const colTitle = c.title;
                const filterState = activeFilters[colKey] || {};
                const filterVal = filterState.value || '';
                const filterCond = filterState.condition || 'contains';
                const hasFilter = !!(filterVal || filterCond === 'empty' || filterCond === 'not_empty');
                const safeKey = String(colKey).replace(/\./g, '_');

                const $th = $(`
                    <th class="dynamic-th" data-column="${colKey}" data-type="text">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-nowrap filter-column-title">${escapeHtml(colTitle)}</span>
                            <div class="dropdown" data-column="${colKey}">
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                                <svg title="Filtreyi Temizle" style="display: ${hasFilter ? 'inline-block' : 'none'}; scale: 1.8;" data-column="${colKey}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M11.6673 11.6667V16.6667L8.33398 18.3333V11.6667L3.33398 4.16667V2.5H16.6673V4.16667L11.6673 11.6667ZM5.33707 4.16667L10.0007 11.162L14.6642 4.16667H5.33707Z" fill="#4069E5"/>
                                </svg>
                                <div class="dropdown-menu p-3" style="min-width: 250px;">
                                    <div class="d-flex flex-column mb-3 sort-options">
                                        <div class="sort-option" data-column="${colKey}" data-order="asc">
                                            <i class="fas fa-sort-alpha-down"></i> A'dan Z'ye
                                        </div>
                                        <div class="sort-option" data-column="${colKey}" data-order="desc">
                                            <i class="fas fa-sort-alpha-down-alt"></i> Z'den A'ya
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <select class="form-select filter-condition" data-column="${colKey}">
                                            <option value="equals" ${filterCond === 'equals' ? 'selected' : ''}>Eşittir</option>
                                            <option value="not_equals" ${filterCond === 'not_equals' ? 'selected' : ''}>Eşit Değildir</option>
                                            <option value="contains" ${filterCond === 'contains' ? 'selected' : ''}>İçerir</option>
                                            <option value="not_contains" ${filterCond === 'not_contains' ? 'selected' : ''}>İçermez</option>
                                            <option value="starts_with" ${filterCond === 'starts_with' || filterCond === 'starts' ? 'selected' : ''}>İle Başlar</option>
                                            <option value="not_starts_with" ${filterCond === 'not_starts_with' || filterCond === 'not_starts' ? 'selected' : ''}>İle Başlamaz</option>
                                            <option value="ends_with" ${filterCond === 'ends_with' || filterCond === 'ends' ? 'selected' : ''}>İle Biter</option>
                                            <option value="not_ends_with" ${filterCond === 'not_ends_with' || filterCond === 'not_ends' ? 'selected' : ''}>İle Bitmez</option>
                                            <option value="empty" ${filterCond === 'empty' ? 'selected' : ''}>Boş</option>
                                            <option value="not_empty" ${filterCond === 'not_empty' ? 'selected' : ''}>Boş Değil</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control w-100 filter-value" placeholder="Ara" data-column="${colKey}" value="${escapeHtml(filterVal)}">
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="d-grid gap-2 mt-2">
                                        <span class="btn btn-outline-primary btn-sm apply-filter" data-column="${colKey}">
                                            Filtreyi Uygula
                                        </span>
                                        <span class="btn btn-outline-danger btn-sm ${hasFilter ? '' : 'd-none'}" id="${safeKey}_clear_filter" onclick="clearColumnFilter('${colKey}', event)">
                                            Filtreyi Temizle
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                `);
                $th.insertBefore($actionTh);
            });
        }

        // (Re)build the DataTable, including any dynamic columns
        window.buildCandidateTable = function() {
        table = $('#{{$tableId}}').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            dom: 'Bfrtip', // Butonları göster
            buttons: {
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'hidden-button'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        className: 'hidden-button'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'hidden-button'
                    }
                ],
                dom: {
                    button: {
                        className: 'hidden-button'
                    }
                }
            },
            ajax: {
                url: '{{$dataurl}}',
                data: function(d) {
                    d.filters = JSON.stringify(activeFilters);
                    if (currentOrder) {
                        d.order = JSON.stringify(currentOrder);
                    }

                    const selectedDynamicColumns = getSelectedDynamicColumns().map(function(c) {
                        return c.data;
                    });
                    if (selectedDynamicColumns.length > 0) {
                        d.dynamic_columns = selectedDynamicColumns;
                    }
                    return d;
                },
                error: function(xhr, error, thrown) {
                    // Check if it's a column not found error
                    if (xhr.status === 500 && xhr.responseText && xhr.responseText.includes('Column not found')) {
                        // Show user-friendly error message
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Seçilen sütun veritabanında bulunamadı. Lütfen geçerli sütunları seçin.');
                        } else {
                            alert('Seçilen sütun veritabanında bulunamadı. Lütfen geçerli sütunları seçin.');
                        }
                        
                        // Uncheck all question columns to prevent further errors
                        $('.question-column').prop('checked', false);
                        if ($.fn.DataTable.isDataTable('#{{$tableId}}')) {
                            table.destroy();
                        }
                        syncDynamicHeaders();
                        buildCandidateTable();
                        return;
                    }
                    
                    // Handle other errors with existing retry logic
                    let retryCount = 0;
                    const maxRetries = 3;
                    const retryDelay = 1000;

                    function retryAjax() {
                        if (retryCount < maxRetries) {
                            retryCount++;
                            setTimeout(function() {
                                table.ajax.reload(null, false);
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
                        {!! $checkboxInitiliazer !!}
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
                                searchable: true,
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
                        @case('aday_katilim_durumu')
                            {
                                data: 'aday_katilim_durumu',
                                name: 'aday_katilim_durumu',
                                orderable: false,
                                searchable: true,
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        switch(data) {
                                            case 'Katıldı':
                                                return '<span class="status-box-success">Katıldı</span>';
                                            case 'Katılmadı':
                                                return '<span class="status-box-danger">Katılmadı</span>';
                                            case 'Mazeretli':
                                                return '<span class="status-box-warning" title="'+(row.aday_katiliim_mazereti || '')+'">Mazeretli</span>';
                                            default:
                                                return data || '-';
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

                        @default
                            {
                                data: '{{ str_contains($key, ".") ? str_replace(".", "_", $key) : $key }}',
                                name: '{{ str_contains($key, ".") ? $key : $key }}',
                                orderable: false,
                                searchable: {{ isset($column['searchable']) ? ($column['searchable'] ? 'true' : 'false') : 'false' }}
                            },
                    @endswitch
                    @endif
                @endforeach
                ...getSelectedDynamicColumns().map(function(c) {
                    if (c.data === 'school_city') {
                        return {
                            data: 'school_city',
                            name: 'school_city',
                            orderable: false,
                            searchable: true,
                            defaultContent: '-',
                            render: function(data, type, row) {
                                return row.p_school_city || row.m_school_city || row.h_school_city || '-';
                            }
                        };
                    }
                    if (c.data === 'school_district') {
                        return {
                            data: 'school_district',
                            name: 'school_district',
                            orderable: false,
                            searchable: true,
                            defaultContent: '-',
                            render: function(data, type, row) {
                                return row.p_school_district || row.m_school_district || row.h_school_district || '-';
                            }
                        };
                    }
                    if (c.data === 'school_name') {
                        return {
                            data: 'school_name',
                            name: 'school_name',
                            orderable: false,
                            searchable: true,
                            defaultContent: '-',
                            render: function(data, type, row) {
                                return row.p_school_name || row.m_school_name || row.h_school_name || '-';
                            }
                        };
                    }
                    if (c.data === 'school_type') {
                        return {
                            data: 'school_type',
                            name: 'school_type',
                            orderable: false,
                            searchable: true,
                            defaultContent: '-',
                            render: function(data, type, row) {
                                return row.primary_educ_type || row.middle_educ_type || row.high_educ_type || '-';
                            }
                        };
                    }
                    return {
                        data: c.data,
                        name: c.data,
                        orderable: false,
                        searchable: true,
                        defaultContent: ''
                    };
                }),
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
                                const $th = $(data);
                                return $th.find('.filter-column-title').text().trim() || $th.text().trim();
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
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':visible:not(:first-child)',
                        format: {
                            header: function(data, columnIdx) {
                                const $th = $(data);
                                return $th.find('.filter-column-title').text().trim() || $th.text().trim();
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
                                const $th = $(data);
                                return $th.find('.filter-column-title').text().trim() || $th.text().trim();
                            }
                        },
                        rows: function(idx, data, node) {
                            const selectedRows = $('.user-checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.user-checkbox').prop('checked');
                            }
                            return true;
                        }
                    },
                    charset: 'utf-8',
                    bom: true,
                    fieldSeparator: ';',  // Excel'de daha iyi görünmesi için
                    fieldBoundary: '"',   // Metin alanlarını çift tırnak içine al
                    escapeChar: '"'       // Kaçış karakteri
                },

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
        };

        // Initial build of headers + table
        syncDynamicHeaders();
        buildCandidateTable();

        // Rebuild the table (headers + columns) whenever a dynamic column is toggled
        $(document).on('change', '.question-column', function() {
            if ($.fn.DataTable.isDataTable('#{{$tableId}}')) {
                table.destroy();
            }
            syncDynamicHeaders();
            buildCandidateTable();
        });

        // Function to initialize table with dynamic columns
        function initializeTableWithDynamicColumns() {
            console.log('=== INITIALIZING TABLE WITH DYNAMIC COLUMNS ===');
            
            // Get selected dynamic columns
            const selectedDynamicColumns = [];
            $('.question-column:checked').each(function() {
                selectedDynamicColumns.push({
                    data: $(this).data('column'),
                    name: $(this).data('column'),
                    title: $(this).data('title'),
                    orderable: false,
                    searchable: true,
                    visible: true
                });
            });

            console.log('Dynamic columns for table:', selectedDynamicColumns);

            // Build columns array
            const columns = [
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data, type, row) {
                        {!! $checkboxInitiliazer !!}
                    }
                }
            ];

            // Add existing columns
            @foreach($columns as $key => $column)
                @if($column['is_visible'])
                    columns.push({
                        data: '{{ str_contains($key, ".") ? str_replace(".", "_", $key) : $key }}',
                        name: '{{ str_contains($key, ".") ? $key : $key }}',
                        orderable: false,
                        searchable: {{ isset($column['searchable']) ? ($column['searchable'] ? 'true' : 'false') : 'false' }}
                    });
                @endif
            @endforeach

            // Add dynamic columns
            selectedDynamicColumns.forEach(function(column) {
                if (column.data === 'school_city') {
                    columns.push({
                        data: 'school_city', name: 'school_city', orderable: false, searchable: true, visible: true, defaultContent: '-',
                        render: function(data, type, row) { return row.p_school_city || row.m_school_city || row.h_school_city || '-'; }
                    });
                } else if (column.data === 'school_district') {
                    columns.push({
                        data: 'school_district', name: 'school_district', orderable: false, searchable: true, visible: true, defaultContent: '-',
                        render: function(data, type, row) { return row.p_school_district || row.m_school_district || row.h_school_district || '-'; }
                    });
                } else if (column.data === 'school_name') {
                    columns.push({
                        data: 'school_name', name: 'school_name', orderable: false, searchable: true, visible: true, defaultContent: '-',
                        render: function(data, type, row) { return row.p_school_name || row.m_school_name || row.h_school_name || '-'; }
                    });
                } else if (column.data === 'school_type') {
                    columns.push({
                        data: 'school_type', name: 'school_type', orderable: false, searchable: true, visible: true, defaultContent: '-',
                        render: function(data, type, row) { return row.primary_educ_type || row.middle_educ_type || row.high_educ_type || '-'; }
                    });
                } else {
                    columns.push({
                        data: column.data,
                        name: column.name,
                        orderable: false,
                        searchable: true,
                        visible: true
                    });
                }
            });

            // Add action column
            columns.push({
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            });

            console.log('Final columns array:', columns);

            // Reinitialize DataTable
            table = $('#{{$tableId}}').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                dom: 'Bfrtip',
                buttons: {
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'hidden-button'
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            className: 'hidden-button'
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            className: 'hidden-button'
                        }
                    ],
                    dom: {
                        button: {
                            className: 'hidden-button'
                        }
                    }
                },
                ajax: {
                    url: '{{$dataurl}}',
                    data: function(d) {
                        console.log('=== REINITIALIZED AJAX START ===');
                        d.filters = JSON.stringify(activeFilters);
                        if (currentOrder) {
                            d.order = JSON.stringify(currentOrder);
                        }
                        
                        // Add dynamic columns to request
                        const selectedDynamicColumns = [];
                        $('.question-column:checked').each(function() {
                            selectedDynamicColumns.push($(this).data('column'));
                        });
                        
                        if (selectedDynamicColumns.length > 0) {
                            d.dynamic_columns = selectedDynamicColumns;
                            console.log('Dynamic columns in reinitialized request:', d.dynamic_columns);
                        }
                        
                        console.log('=== REINITIALIZED AJAX END ===');
                    },
                    error: function(xhr, error, thrown) {
                        console.log('Error in reinitialized table:', xhr, error, thrown);
                    }
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('redirect-row cursor-pointer')
                        .attr('data-id', data.id);
                },
                columns: columns,
                ordering: false,
                pageLength: 25,
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
                language: {
                    url: '{{url('')}}/public/build/js/dataTables/tr.json',
                    paginate: {
                        previous: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                                 '<path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"></path>' +
                                 '</svg>',
                        next: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                              '<path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"></path>' +
                              '</svg>'
                    }
                },
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
            
            console.log('=== TABLE INITIALIZED WITH DYNAMIC COLUMNS ===');
        }

        // Function to add dynamic columns to table
        function addDynamicColumns() {
            const allQuestionCheckboxes = $('.question-column');
            console.log('Found question checkboxes:', allQuestionCheckboxes.length);
            
            const selectedDynamicColumns = [];
            $('.question-column:checked').each(function() {
                console.log('Found checked checkbox:', $(this).data('column'));
                selectedDynamicColumns.push({
                    data: $(this).data('column'),
                    name: $(this).data('column'),
                    title: $(this).data('title'),
                    orderable: false,
                    searchable: true,
                    visible: true
                });
            });

            console.log('Selected dynamic columns count:', selectedDynamicColumns.length);
            
            // Store dynamic columns for use in AJAX requests
            window.dynamicColumns = selectedDynamicColumns;
        }

        // (dynamic column toggling handled by the consolidated handler above)

        
        // Add dynamic columns to DataTables configuration
        function updateTableColumns() {
            const selectedDynamicColumns = [];
            $('.question-column:checked').each(function() {
                selectedDynamicColumns.push({
                    data: $(this).data('column'),
                    name: $(this).data('column'),
                    title: $(this).data('title'),
                    orderable: false,
                    searchable: true,
                    visible: true
                });
            });

            // Update DataTables columns configuration
            const currentColumns = table.settings()[0].aoColumns;
            
            // Remove existing dynamic columns
            const staticColumns = currentColumns.filter(col => col.name !== 'action' && !col.name.startsWith('dynamic_'));
            
            // Add new dynamic columns
            selectedDynamicColumns.forEach(function(column) {
                staticColumns.push({
                    mData: column.data,
                    name: column.name,
                    title: column.title,
                    orderable: column.orderable,
                    searchable: column.searchable,
                    visible: column.visible,
                    bVisible: column.visible
                });
            });
            
            // Add action column back
            staticColumns.push({
                mData: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                visible: true
            });
            
            // Update table settings
            table.settings()[0].aoColumns = staticColumns;
        }

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
        $(document).on('click', '.sort-option', function() {
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

        // Filtre kutusunda Enter basıldığında filtre uygula
        $(document).on('keypress', '.filter-value', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $(this).closest('.dropdown-menu').find('.apply-filter').trigger('click');
            }
        });

        // Filtre uygulama
        $(document).on('click', '.apply-filter', function() {
            const column = $(this).data('column');
            const $filterMenu = $(this).closest('.dropdown-menu');
            const value = $filterMenu.find('.filter-value').val();
            const condition = $filterMenu.find('.filter-condition').val();
            // Checkbox'lar için: sütun adında nokta olsa bile CSS selector oluşturmayız.
            const checkedBoxes = $filterMenu
                .find('.checkbox-group input[type="checkbox"]:checked')
                .not('[id^="select_all_"]')
                .map(function() {
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
            $filterMenu.find('[id$="_clear_filter"]').removeClass('d-none');
            $('.dropdown-menu').removeClass('show');
            updateFilterIcon(column, true);
            table.draw();
        });

        // Dropdown menünün dışına tıklandığında kapanmasını engelle
        $(document).on('click', '.dropdown-menu', function(e) {
            // e104 sonrası filtre ve sıralama olayları document seviyesinde dinleniyor.
            // Bu iki eylemin üst öğeye ulaşmasını engelleme.
            if (!$(e.target).closest('.apply-filter, .sort-option').length) {
                e.stopPropagation();
            }
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

        // Aynı sütun adı birden fazla tabloda kullanılsa da menü içindeki
        // alanları hedefle. Bu, "form.status" gibi noktalı isimleri de destekler.
        const $columnDropdown = $('.dropdown[data-column]').filter(function() {
            return String($(this).attr('data-column')) === String(columnName);
        }).first();
        const $filterMenu = $columnDropdown.find('.dropdown-menu');

        // Filtre değerlerini temizle
        $filterMenu.find('.filter-value').val('');
        $filterMenu.find('.filter-condition').prop('selectedIndex', 0);

        // Checkbox'ları ve "Tümünü Seç" alanını temizle
        $filterMenu.find('.checkbox-group input[type="checkbox"]').prop('checked', false);

        // Temizle butonunu gizle
        $filterMenu.find('[id$="_clear_filter"]').addClass('d-none');

        // Aktif filtreleri temizle
        delete activeFilters[columnName];

        // İkonu gizle
        updateFilterIcon(columnName, false);

        // Dropdown'ı kapat
        $filterMenu.removeClass('show');

        // Tabloyu yenile
        table.draw();
    }
    $(document).on('change', '[id^="select_all_"]', function() {
                const columnName = this.id.replace('select_all_', '');
                const isChecked = $(this).prop('checked');

                // Tüm ilgili checkbox'ları aynı menü içinde güncelle.
                $(this).closest('.dropdown-menu')
                    .find('.checkbox-group input[type="checkbox"]')
                    .not(this)
                    .prop('checked', isChecked);

            });
    $(document).on('change', '.checkbox-group input[type="checkbox"]:not([id^="select_all_"])', function() {
        const $group = $(this).closest('.checkbox-group');
        const $options = $group.find('input[type="checkbox"]:not([id^="select_all_"])');
        const checkedCount = $options.filter(':checked').length;

        $group.find('[id^="select_all_"]')
            .prop('checked', checkedCount === $options.length && $options.length > 0)
            .prop('indeterminate', checkedCount > 0 && checkedCount < $options.length);
    });
            function getHiddenColumnIndexes() {
            let hiddenIndexes = [];
        let docColumns = {!! json_encode($docColumns) !!}; // PHP'den gelen docColumns dizisi

        // Tablo başlıklarını dolaş
        $('table:first thead th').each(function(index) {
            let columnName = $(this).data('column');
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
                console.log('Excel export button clicked');
                @if(!empty($renewServerExcelExport))
                    excelServerExportRenew();
                @elseif(!empty($bursiyerServerExcelExport))
                    excelServerExportBursiyer();
                @elseif(!empty($mezunServerExcelExport))
                    excelServerExportMezun();
                @elseif(Route::has('aday.export.start'))
                    excelServerExport();
                @else
                    exportTable('excel');
                @endif
            });

            // PDF export
            $('#pdfButton').on('click', function() {
                console.log('PDF export button clicked');
                exportTable('pdf');
            });

            // CSV export
            $('#csvButton').on('click', function() {
                console.log('CSV export button clicked');
                exportTable('csv');
            });

        @if(!empty($renewServerExcelExport))
        function excelServerExportRenew() {
            const selectedRows = $('.user-checkbox:checked');
            const selectedIds = [];
            selectedRows.each(function() {
                const fid = $(this).data('export-id') || $(this).data('exportId');
                if (fid) {
                    selectedIds.push(fid);
                }
            });

            const visibleColumns = [];
            $('.column-visibility:checked').each(function() {
                visibleColumns.push($(this).data('column'));
            });

            const filters = typeof activeFilters !== 'undefined' ? activeFilters : {};
            const searchValue = (typeof table !== 'undefined' && table.search) ? table.search() : '';

            $('#exportProgressModal').modal('show');
            $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
            $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

            $.ajax({
                url: '{{ route("renew.export.start") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userIds: selectedIds.length > 0 ? JSON.stringify(selectedIds) : JSON.stringify([]),
                    filters: JSON.stringify(filters),
                    visibleColumns: JSON.stringify(visibleColumns),
                    search: { value: searchValue },
                    wideExport: false
                },
                success: function(response) {
                    const exportId = response.exportId;
                    const total = response.total;
                    const batchSize = response.batchSize;
                    const totalChunks = Math.ceil(total / batchSize);

                    if (total === 0) {
                        if (typeof toastr !== 'undefined') {
                            toastr.warning('Aktarılacak kayıt bulunamadı.');
                        } else {
                            alert('Aktarılacak kayıt bulunamadı.');
                        }
                        $('#exportProgressModal').modal('hide');
                        return;
                    }

                    excelProcessChunkRenew(exportId, 0, totalChunks, batchSize, total);
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Export başlatılamadı.');
                    } else {
                        alert('Export başlatılamadı.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelProcessChunkRenew(exportId, index, totalChunks, batchSize, total) {
            if (index >= totalChunks) {
                excelFinalizeExportRenew(exportId, totalChunks);
                return;
            }

            const progress = Math.round((index / totalChunks) * 100);
            $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
            $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

            $.ajax({
                url: '{{ route("renew.export.chunk") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    chunkIndex: index,
                    batchSize: batchSize
                },
                success: function() {
                    excelProcessChunkRenew(exportId, index + 1, totalChunks, batchSize, total);
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Parça işlenirken hata oluştu.');
                    } else {
                        alert('Parça işlenirken hata oluştu.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelFinalizeExportRenew(exportId, totalChunks) {
            $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
            $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

            $.ajax({
                url: '{{ route("renew.export.finalize") }}',
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
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Dosya oluşturulamadı.');
                    } else {
                        alert('Dosya oluşturulamadı.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }
        @endif

        @if(!empty($mezunServerExcelExport))
        function excelServerExportMezun() {
            const selectedRows = $('.user-checkbox:checked');
            const selectedIds = [];
            selectedRows.each(function() {
                const id = $(this).data('id') || $(this).val();
                if (id) selectedIds.push(id);
            });

            const visibleColumns = [];
            $('.column-visibility:checked').each(function() {
                visibleColumns.push($(this).data('column'));
            });

            const filters = typeof activeFilters !== 'undefined' ? activeFilters : {};
            const searchValue = (typeof table !== 'undefined' && table.search) ? table.search() : '';

            $('#exportProgressModal').modal('show');
            $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
            $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

            $.ajax({
                url: '{{ route("mezunlar.export.start") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userIds: selectedIds.length > 0 ? JSON.stringify(selectedIds) : JSON.stringify([]),
                    filters: JSON.stringify(filters),
                    visibleColumns: JSON.stringify(visibleColumns),
                    search: { value: searchValue }
                },
                success: function(response) {
                    const exportId = response.exportId;
                    const total = response.total;
                    const batchSize = response.batchSize;
                    const totalChunks = Math.ceil(total / batchSize);

                    if (total === 0) {
                        if (typeof toastr !== 'undefined') {
                            toastr.warning('Aktarılacak kayıt bulunamadı.');
                        } else {
                            alert('Aktarılacak kayıt bulunamadı.');
                        }
                        $('#exportProgressModal').modal('hide');
                        return;
                    }

                    excelProcessChunkMezun(exportId, 0, totalChunks, batchSize, total);
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Export başlatılamadı.');
                    } else {
                        alert('Export başlatılamadı.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelProcessChunkMezun(exportId, index, totalChunks, batchSize, total) {
            if (index >= totalChunks) {
                excelFinalizeExportMezun(exportId, totalChunks);
                return;
            }

            const progress = Math.round((index / totalChunks) * 100);
            $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
            $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

            $.ajax({
                url: '{{ route("mezunlar.export.chunk") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    index: index,
                    batchSize: batchSize
                },
                success: function() {
                    excelProcessChunkMezun(exportId, index + 1, totalChunks, batchSize, total);
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Parça işlenirken hata oluştu.');
                    } else {
                        alert('Parça işlenirken hata oluştu.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelFinalizeExportMezun(exportId, totalChunks) {
            $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
            $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

            $.ajax({
                url: '{{ route("mezunlar.export.finalize") }}',
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
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Dosya oluşturulamadı.');
                    } else {
                        alert('Dosya oluşturulamadı.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }
        @endif

        @if(!empty($bursiyerServerExcelExport))
        function excelServerExportBursiyer() {
            const selectedRows = $('.user-checkbox:checked');
            const selectedIds = [];
            selectedRows.each(function() {
                const id = $(this).data('id') || $(this).val();
                if (id) selectedIds.push(id);
            });

            const visibleColumns = [];
            $('.column-visibility:checked').each(function() {
                visibleColumns.push($(this).data('column'));
            });

            const filters = typeof activeFilters !== 'undefined' ? activeFilters : {};
            const searchValue = (typeof table !== 'undefined' && table.search) ? table.search() : '';

            $('#exportProgressModal').modal('show');
            $('#exportProgressBar').css('width', '0%').attr('aria-valuenow', 0).text('0%');
            $('#exportProgressStatus').text('Dışa aktarma başlatılıyor...');

            $.ajax({
                url: '{{ route("bursiyer.export.start") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    userIds: selectedIds.length > 0 ? JSON.stringify(selectedIds) : JSON.stringify([]),
                    filters: JSON.stringify(filters),
                    visibleColumns: JSON.stringify(visibleColumns),
                    // DataTables ile aynı yapı (search[value])
                    search: { value: searchValue }
                },
                success: function(response) {
                    const exportId = response.exportId;
                    const total = response.total;
                    const batchSize = response.batchSize;
                    const totalChunks = Math.ceil(total / batchSize);

                    if (total === 0) {
                        if (typeof toastr !== 'undefined') {
                            toastr.warning('Aktarılacak kayıt bulunamadı.');
                        } else {
                            alert('Aktarılacak kayıt bulunamadı.');
                        }
                        $('#exportProgressModal').modal('hide');
                        return;
                    }

                    excelProcessChunkBursiyer(exportId, 0, totalChunks, batchSize, total);
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Export başlatılamadı.');
                    } else {
                        alert('Export başlatılamadı.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelProcessChunkBursiyer(exportId, index, totalChunks, batchSize, total) {
            if (index >= totalChunks) {
                excelFinalizeExportBursiyer(exportId, totalChunks);
                return;
            }

            const progress = Math.round((index / totalChunks) * 100);
            $('#exportProgressBar').css('width', progress + '%').attr('aria-valuenow', progress).text(progress + '%');
            $('#exportProgressStatus').text('Parça ' + (index + 1) + ' / ' + totalChunks + ' işleniyor...');

            $.ajax({
                url: '{{ route("bursiyer.export.chunk") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    exportId: exportId,
                    index: index,
                    batchSize: batchSize
                },
                success: function() {
                    excelProcessChunkBursiyer(exportId, index + 1, totalChunks, batchSize, total);
                },
                error: function() {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Parça işlenirken hata oluştu.');
                    } else {
                        alert('Parça işlenirken hata oluştu.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }

        function excelFinalizeExportBursiyer(exportId, totalChunks) {
            $('#exportProgressStatus').text('Dosya birleştiriliyor ve Excel oluşturuluyor...');
            $('#exportProgressBar').css('width', '100%').attr('aria-valuenow', 100).text('100%');

            $.ajax({
                url: '{{ route("bursiyer.export.finalize") }}',
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
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Dosya oluşturulamadı.');
                    } else {
                        alert('Dosya oluşturulamadı.');
                    }
                    $('#exportProgressModal').modal('hide');
                }
            });
        }
        @endif

        @if(Route::has('aday.export.start') && empty($bursiyerServerExcelExport) && empty($renewServerExcelExport) && empty($mezunServerExcelExport))
        // Excel sunucu taraflı export fonksiyonu (tüm filtrelenmiş veriyi aktarır)
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

            // Aktif filtreleri al
            const filters = typeof activeFilters !== 'undefined' ? activeFilters : {};

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
        @endif

        // Export fonksiyonu (PDF, CSV ve fallback Excel için)
        function exportTable(type) {
            console.log('Starting export process for type:', type);

            // Seçili satırları al
            const selectedRows = $('.user-checkbox:checked');
            console.log('Selected rows:', selectedRows.length);

            // Sadece görünür sütunların başlıklarını al
            const visibleColumns = table.columns(':visible:not(:first-child)').header().map(function() {
                return $(this).find('.column-header').contents().first().text().trim();
            }).toArray();
            console.log('Visible columns:', visibleColumns);

            // Export seçeneklerini ayarla
            const exportOptions = {
                columns: ':visible:not(:first-child)', // Checkbox sütununu hariç tut
                rows: function(idx, data, node) {
                    const selectedRows = $('.user-checkbox:checked');
                    if (selectedRows.length > 0) {
                        return $(node).find('.user-checkbox').prop('checked');
                    }
                    return true;
                },
                format: {
                    header: function(data, columnIdx) {
                        return visibleColumns[columnIdx];
                    }
                }
            };
            console.log('Export options configured:', exportOptions);

            // Export butonlarını yapılandır
            const buttonConfig = {
                extend: type,
                exportOptions: exportOptions,
                customize: function(doc) {

                        // PDF özelleştirmeleri
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('*');
                }
            };
            console.log('Button config:', buttonConfig);

            // Export işlemini gerçekleştir
            console.log('Attempting to trigger export button:', `.buttons-${type}`);
            try {
                const button = table.button(`.buttons-${type}`);
                if (button) {
                    console.log('Found DataTables button, triggering...');
                    button.trigger();
                } else {
                    console.error('DataTables button not found');
                }
            } catch (error) {
                console.error('Error triggering export:', error);
            }
        }
    </script>

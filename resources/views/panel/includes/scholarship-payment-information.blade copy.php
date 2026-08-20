<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('burs-odeme-duzenle', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});
$('#reload').on('click', function(e) {
    location.reload();
});
</script>
<script>
    function dropdownKapat(){
        $('.dropdown-menu').removeClass('show');
    }
    function clearFilter(columnName) {
        $(`.${columnName}-check`).prop('checked', false);
        $(`#select_all_${columnName}`).prop('checked', false);
        $(`#${columnName}_value`).val('');
        $(`#${columnName}_condition`).val('');
        $(`#${columnName}_selected_filters`).empty();

        delete filters[columnName];
        updateFilterIcon(columnName, false);
        $(`#${columnName}_clear_filter`).addClass('d-none');

        table.ajax.reload();
    }
</script>
<script>
    $(document).ready(function() {
        $('#export').on('click', function(e) {
            e.preventDefault();
            $('#export-menu').toggleClass('show');
        });
        // Export işlemleri için click handler'lar

    });
    $('#search').on('click', function() {
            $('#paymentInfoTable_filter label').toggleClass('d-none');
        });
    </script>
<script>
    // Global değişkenler
    let filters = {};
    let table;
    let currentSort = {
        column: null,
        direction: null
    };

    // Tüm otomatik filtreleme olaylarını kaldır
    $('.filter-input').off('keyup keypress change');
    $('.checkbox-group input[type="checkbox"]').off('change');

    // Select all checkbox işlevi
    $(document).on('change', '[id^="select_all_"]', function() {
        const columnName = this.id.replace('select_all_', '');
        const isChecked = $(this).prop('checked');
        $(`.${columnName}-check`).prop('checked', isChecked);
    });



    // Filtre değeri kaldırma (sadece text ve number için)
    function removeFilterValue(columnName, value) {
        const inputElement = $(`#${columnName}_value`);
        const elementType = inputElement.attr('type');

        if ((elementType === 'text' || elementType === 'number') && filters[columnName]) {
            filters[columnName].values = filters[columnName].values.filter(v => v !== value);
            $(`.badge[data-value="${value}"]`).remove();

            if (filters[columnName].values.length === 0) {
                delete filters[columnName];
                updateFilterIcon(columnName, false);
                $(`#${columnName}_clear_filter`).addClass('d-none');
            }

            table.ajax.reload();
        }
    }

    // Filtre temizleme
    function clearColumnFilter(columnName, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        // Input değerini temizle
        $(`#${columnName}_value`).val('');

        // Checkbox'ları temizle
        $(`.${columnName}-check`).prop('checked', false);
        $(`#select_all_${columnName}`).prop('checked', false);

        // Text ve number inputlar için badge'leri temizle
        const elementType = $(`#${columnName}_value`).attr('type');
        if (elementType === 'text' || elementType === 'number') {
            $(`#${columnName}_selected_filters`).empty();
        }

        // Filtreyi kaldır
        delete filters[columnName];
        updateFilterIcon(columnName, false);
        $(`#${columnName}_clear_filter`).addClass('d-none');

        table.ajax.reload();
    }

    // Filtre ikonu güncelleme
    function updateFilterIcon(columnName, hasFilter) {
        const columnHeader = $(`.column-header[data-column="${columnName}"]`);
        const filterIcon = columnHeader.find('svg[data-column="' + columnName + '"]');

        if (hasFilter) {
            filterIcon.show();
        } else {
            filterIcon.hide();
        }
    }

    // Sıralama işlevi
    function sortColumn(columnName, direction) {
        currentSort.column = columnName;
        currentSort.direction = direction;
        table.ajax.reload();
    }

    let columns = @json($columns);
        // Filtre temizleme fonksiyonu
        function clearColumnFilter(columnName, event = null) {
            // Event parametresi varsa, event propagation'ı durdur
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            // Input filtresini temizle
            $(`#${columnName}_value`).val('');

            // Checkbox'ları temizle
            $(`.${columnName}-check`).prop('checked', false);

            // Select all checkbox'ı temizle
            $(`#select_all_${columnName}`).prop('checked', false);

            // Filtreyi kaldır
            delete filters[columnName];

            // İkonu gizle
            updateFilterIcon(columnName, false);

            // Dropdown'ı kapat
            const dropdownMenu = $(`[data-column="${columnName}"]`).closest('.dropdown').find('.dropdown-menu');
            const dropdownInstance = bootstrap.Dropdown.getInstance(dropdownMenu.prev()[0]);
            if (dropdownInstance) {
                dropdownInstance.hide();
            }

            // Tabloyu yenile
            table.ajax.reload();
        }
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


                            case 'okul_tipi':
                                return getEducationType(row.okul_tipi);
                            case 'form.islemi_yapan':
                                return row.scholar?.form?.[0]?.islemi_yapan || '';
                            case 'odeme_durumu':
                                return getStatus(row.odeme_durumu);
                            case 'educationType':
                                return getEducationType(row.educationType);
                            case 'form.scholar.aday_id':
                                return row.form?.scholar?.aday_id || '';
                            case 'ogrenciye_burs_odeme_tarihi':
                                return row.ogrenciye_burs_odeme_tarihi ? moment(row.ogrenciye_burs_odeme_tarihi).format('DD.MM.YYYY') : '';
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
                var url = "{{ route('burs-odeme-duzenle', ['id' => ':id']) }}".replace(':id', row.id);
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

        // Debounce fonksiyonu
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

         // Debounce fonksiyonu
         function debounce(func, wait) {
            let timeout;
            return function(...args) {
                const context = this;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }




        // Sütun görünürlüğünü değiştir
        function toggleColumnVisibility(columnName, isVisible) {
            const columnIndex = getColumnIndexByName(columnName);
            if (columnIndex !== -1) {
                table.column(columnIndex).visible(isVisible);
            }
        }


        // Sütun adına göre index bul
        function getColumnIndexByName(columnName) {
            let columnIndex = -1;
            table.columns().every(function(index) {
                if (this.dataSrc() === columnName) {
                    columnIndex = index;
                    return false; // döngüyü durdur
                }
            });
            return columnIndex;
        }




            function loadColumnVisibility() {
            const savedState = localStorage.getItem('columnVisibility');
            if (savedState) {
                const visibilityState = JSON.parse(savedState);

                // Her sütun için görünürlük durumunu uygula
                Object.entries(visibilityState).forEach(([columnName, isVisible]) => {
                    // Checkbox'ı güncelle
                    $(`#${columnName}Checkbox`).prop('checked', isVisible);

                    // Sütun görünürlüğünü güncelle
                    toggleColumnVisibility(columnName, isVisible);
                });
            }
        }
        // DataTable tanımlaması
        table = $('#paymentInfoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('paymentlist.data') }}",
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

        // Görünürlük durumlarını localStorage'a kaydet
        function saveColumnVisibility() {
            const visibilityState = {};
            $('.column-visibility').each(function() {
                const columnName = $(this).data('column');
                visibilityState[columnName] = $(this).prop('checked');
            });
            localStorage.setItem('columnVisibility', JSON.stringify(visibilityState));
        }
        // Sütun görünürlüğü için fonksiyonlar
        $(document).ready(function() {
            // Sütun görünürlük durumlarını localStorage'dan yükle

            // Checkbox değişikliklerini dinle
            $(document).on('change', '.column-visibility', function() {
                const columnName = $(this).data('column');
                const isVisible = $(this).prop('checked');

                // Sütun görünürlüğünü güncelle
                toggleColumnVisibility(columnName, isVisible);

                // Görünürlük durumunu localStorage'a kaydet
                saveColumnVisibility();
            });
        });
        // localStorage'dan görünürlük durumlarını yükle

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

        // "Tümünü Seç/Kaldır" işlevselliği
        $('[id^="select_all_"]').on('change', function() {
            const columnName = this.id.replace('select_all_', '');
            const isChecked = $(this).prop('checked');

            // Tüm ilgili checkbox'ları güncelle
            $(`.${columnName}-check`).prop('checked', isChecked);

            // Filtreleri uygula
            applyFilters();
        });



    });

    function sortColumn(column, direction) {
        currentSort = {
            column: column,
            direction: direction
        };

        // Tabloyu yenile
        table.ajax.reload();
    }

    function applyFilters() {
        // Checkbox sütunları için array
        const checkboxColumns = ['interview_platform', 'interview_result', 'educationType'];

        // Checkbox filtreleri için
        checkboxColumns.forEach(columnName => {
            const checkedValues = $(`.${columnName}-check:checked`).map(function() {
                return $(this).val();
            }).get();

            if (checkedValues.length > 0) {
                filters[columnName] = {
                    value: checkedValues,
                    condition: 'in'
                };
                updateFilterIcon(columnName, true);
            } else {
                delete filters[columnName];
                updateFilterIcon(columnName, false);
            }
        });

        // Text input filtreleri
        $('.filter-input').each(function() {
            const columnName = $(this).data('column');
            const value = $(this).val();
            const condition = $(`#${columnName}_condition`).val() || 'contains';
            if (value) {
                filters[columnName] = {
                    value: value,
                    condition: condition
                };
                updateFilterIcon(columnName, true);
            }
        });

        // Okul adı filtresi için özel işlem
        const schoolNameValue = $('#p_school_name_value').val();
        if (schoolNameValue) {
            filters['school_name'] = {
                value: schoolNameValue,
                condition: $('#p_school_name_condition').val() || 'contains',
                educationType: filters['educationType'] ? filters['educationType'].value : null
            };
        }

        // Sınıf filtresi için özel işlem
        const classValue = $('#class_value').val();
        if (classValue) {
            filters['class'] = {
                value: classValue,
                condition: $('#class_condition').val() || 'contains',
                educationType: filters['educationType'] ? filters['educationType'].value : null
            };
        }

        // Debug için filtreleri konsola yazdır
        console.log('Uygulanan filtreler:', filters);

        // Tabloyu yenile
        table.ajax.reload();
    }
    // Filtre değiştiğinde çalışacak fonksiyon
    $('.filter-condition').on('change', function() {
        const columnName = $(this).data('column');
        const selectedValue = $(this).val();
        const inputContainer = $(`#${columnName}_value_container`);

        if (selectedValue === 'null') {
            inputContainer.hide();
            // Input değerini temizle ve filtreyi uygula
            $(`#${columnName}_value`).val('');
            updateFilter(columnName, null, 'null');
        } else {
            inputContainer.show();
        }
    });

    // Filtre güncelleme fonksiyonu
    function updateFilter(columnName, value, condition) {
        alert(condition);
        if (condition === 'null') {
            filters[columnName] = {
                value: null,
                condition: 'null'
            };
        } else {
            filters[columnName] = {
                value: value,
                condition: condition
            };
        }

        updateFilterIcon(columnName, true);
        table.ajax.reload();
    }



    // Filtre koşulu değişikliklerini dinle
    $(document).on('change', '.filter-condition', function() {
        applyFilters();
    });

    $(document).ready(function() {
        // Dropdown'ların kapanmasını engelle
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });

        // Dropdown tetikleyicileri için özel işleyici
        $('.column-header').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // En yakın dropdown menüyü bul
            const dropdownMenu = $(this).closest('.dropdown').find('.dropdown-menu');

            // Diğer tüm açık dropdown'ları kapat
            $('.dropdown-menu').not(dropdownMenu).removeClass('show');

            // Tıklanan dropdown'ı aç/kapat
            dropdownMenu.toggleClass('show');
        });

        // Sayfa herhangi bir yerine tıklandığında dropdown'ları kapat
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });



        // Sütun görünürlüğünü kontrol etmek için
        $('.form-check-input').on('change', function() {
            const columnIndex = $(this).attr('id').replace('vischk', '');
            const column = table.column(columnIndex);
            column.visible(this.checked);

        });
    });

    // Dropdown menülerin dışına tıklandığında kapanması için
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });

    // Dropdown toggle butonları için
    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const dropdownMenu = $(this).next('.dropdown-menu');
        $('.dropdown-menu').not(dropdownMenu).removeClass('show');
        dropdownMenu.toggleClass('show');
    });

    // Kolon başlıkları için özel dropdown işleyici
    $('.column-header').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const dropdownMenu = $(this).closest('.dropdown').find('.dropdown-menu');
        $('.dropdown-menu').not(dropdownMenu).removeClass('show');
        dropdownMenu.toggleClass('show');
    });

    // Dropdown menü içindeki tıklamaların menüyü kapatmaması için
    $('.dropdown-menu').on('click', function(e) {
        e.stopPropagation();
    });

    // Sayfa yüklendiğinde ilk veri yüklemesi başarısız olursa yeniden dene
    $(document).ready(function() {
        table.on('error.dt', function(e, settings, techNote, message) {
            console.log('DataTables error:', message);
            setTimeout(function() {
                table.ajax.reload(null, false);
            }, 1000);
        });
    });

    function addFilter(columnName) {
        const value = $(`#${columnName}_value`).val();
        if (!value) return;

        // Filtre objesini doğru şekilde başlat
        if (!filters[columnName]) {
            filters[columnName] = {
                values: [],
                condition: $(`#${columnName}_condition`).val() || 'contains'
            };
        }

        // Eğer values dizisi tanımlı değilse, oluştur
        if (!Array.isArray(filters[columnName].values)) {
            filters[columnName].values = [];
        }

        // Değer zaten varsa ekleme
        if (!filters[columnName].values.includes(value)) {
            // Değeri ekle
            filters[columnName].values.push(value);

            // Badge'i ekle
            const badge = `
                <span class="badge bg-primary me-1 mb-1" data-value="${value}">
                    ${value}
                    <i class="fas fa-times ms-1" style="cursor: pointer;" onclick="removeFilter('${columnName}', '${value}')"></i>
                </span>
            `;
            $(`#${columnName}_selected_filters`).append(badge);

            // Input'u temizle
            $(`#${columnName}_value`).val('');

            // Filtre ikonunu güncelle
            updateFilterIcon(columnName, true);

            // Filtreyi uygula
            applyFilters();
        }
    }

    function removeFilter(columnName, value) {
        if (filters[columnName] && Array.isArray(filters[columnName].values)) {
            // Değeri diziden kaldır
            filters[columnName].values = filters[columnName].values.filter(v => v !== value);

            // Eğer hiç değer kalmadıysa filtre objesinden kaldır
            if (filters[columnName].values.length === 0) {
                delete filters[columnName];
                updateFilterIcon(columnName, false);
            }

            // Badge'i kaldır
            $(`.badge[data-value="${value}"]`).remove();

            // Filtreyi uygula
            applyFilters();
        }
    }

    // Search input'u için olay dinleyicisi
    $('#search').on('click', function() {
        table.search($('#searchInput').val()).draw();
    });

    // Enter tuşu ile filtreleme
    $('.filter-input').on('keypress', function(e) {
        if (e.which === 13) { // Enter tuşu
            const columnName = $(this).data('column');
            addFilter(columnName);
        }
    });


    function removeFilterValue(columnName, value) {
        const inputElement = $(`#${columnName}_value`);
        const inputType = inputElement.attr('type');

        if ((inputType === 'text' || inputType === 'number') && filters[columnName]) {
            filters[columnName].values = filters[columnName].values.filter(v => v !== value);
            $(`.badge[data-value="${value}"]`).remove();

            if (filters[columnName].values.length === 0) {
                delete filters[columnName];
                updateFilterIcon(columnName, false);
                $(`#${columnName}_clear_filter`).addClass('d-none');
            }

            table.ajax.reload();
        }
    }

    function clearColumnFilter(columnName, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        const inputElement = $(`#${columnName}_value`);
        const inputType = inputElement.attr('type');

        // Input değerini temizle
        inputElement.val('');

        // Checkbox'ları temizle
        $(`.${columnName}-check`).prop('checked', false);
        $(`#select_all_${columnName}`).prop('checked', false);

        // Sadece text ve number inputlar için badge'leri temizle
        if (inputType === 'text' || inputType === 'number') {
            $(`#${columnName}_selected_filters`).empty();
        }

        // Filtreyi kaldır
        delete filters[columnName];

        // Filtre ikonunu gizle
        updateFilterIcon(columnName, false);

        // Filtre temizle butonunu gizle
        $(`#${columnName}_clear_filter`).addClass('d-none');

        // Tabloyu güncelle
        table.ajax.reload();
    }

    // Checkbox'ların "change" event listener'ını kaldır
    $('.checkbox-group input[type="checkbox"]').off('change');

    // Input'ların "keyup" event listener'ını kaldır
    $('.filter-input').off('keyup');

    // Enter tuşu ile filtreleme özelliğini kaldır
    $('.filter-input').off('keypress');

    // Select all checkbox işlevini güncelle
    $(document).on('change', '[id^="select_all_"]', function() {
        const columnName = this.id.replace('select_all_', '');
        const isChecked = $(this).prop('checked');
        $(`.${columnName}-check`).prop('checked', isChecked);
        // Otomatik filtreleme kaldırıldı
    });

    // Sadece "Filtreyi Uygula" butonu ile çalışacak fonksiyon


    // Badge kaldırma işlemi güncellemesi
    function removeFilterValue(columnName, value) {
        if (filters[columnName] && filters[columnName].values) {
            filters[columnName].values = filters[columnName].values.filter(v => v !== value);
            $(`.badge[data-value="${value}"]`).remove();
            $(`.${columnName}-check[value="${value}"]`).prop('checked', false);

            if (filters[columnName].values.length === 0) {
                delete filters[columnName];
                updateFilterIcon(columnName, false);
                $(`#${columnName}_clear_filter`).addClass('d-none');
            }

            table.ajax.reload();
        }
    }

    // Otomatik filtreleme olaylarını kaldır
    $('.filter-input').off('keyup keypress change');
    $('.checkbox-group input[type="checkbox"]').off('change');

    // Sadece "Filtreyi Uygula" butonuna tıklandığında çalışacak fonksiyon
    function applyColumnFilter(columnName) {
        const inputValue = $(`#${columnName}_value`).val();
        const checkedBoxes = $(`.${columnName}-check:checked`).map(function() {
            return $(this).val();
        }).get();
        const inputElement = $(`#${columnName}_value`);

        const inputType = inputElement.attr('type');

        // Input tipi text veya number ise ve değer varsa
        if ((inputType === 'text' || inputType === 'number') && inputValue) {
            // Filtre objesini oluştur veya güncelle
            if (!filters[columnName]) {
                filters[columnName] = {
                    values: [],
                    condition: $(`#${columnName}_condition`).val() || 'contains'
                };
            }

            // Değeri ekle ve badge oluştur
            if (!filters[columnName].values.includes(inputValue)) {
                filters[columnName].values.push(inputValue);
                const badge = `
                    <span class="badge bg-primary me-1 mb-1" data-value="${inputValue}">
                        ${inputValue}
                        <i class="fas fa-times ms-1" style="cursor: pointer;"
                           onclick="removeFilterValue('${columnName}', '${inputValue}')"></i>
                    </span>
                `;
                $(`#${columnName}_selected_filters`).append(badge);
                inputElement.val(''); // Input alanını temizle
            }
        }
        // Checkbox veya date tipi için
        else if (inputType === 'date' || checkedBoxes.length > 0) {
            filters[columnName] = {
                values: inputType === 'date' ? [inputValue] : checkedBoxes,
                condition: $(`#${columnName}_condition`).val() || 'contains'
            };
        }

        // Filtre değeri varsa
        if (filters[columnName] && filters[columnName].values.length > 0) {
            // Filtre temizle butonunu göster
            $(`#${columnName}_clear_filter`).removeClass('d-none');
            // Filtre ikonunu göster
            updateFilterIcon(columnName, true);
            // Tabloyu güncelle
            table.ajax.reload();
        }
        dropdownKapat();
    }

    // Badge kaldırma işlemi (sadece text ve number inputlar için)
    function removeFilterValue(columnName, value) {
        const inputElement = $(`#${columnName}_value`);
        const inputType = 'text';

        if ((inputType === 'text' || inputType === 'number') && filters[columnName]) {
            filters[columnName].values = filters[columnName].values.filter(v => v !== value);
            $(`.badge[data-value="${value}"]`).remove();

            if (filters[columnName].values.length === 0) {
                delete filters[columnName];
                updateFilterIcon(columnName, false);
                $(`#${columnName}_clear_filter`).addClass('d-none');
            }

            table.ajax.reload();
        }
    }

</script>

<script>
    function addInputClearButton(container) {
        if (container.find('.clear-filter').length) return;

        const clearBtn = $(`
            <button class="btn btn-sm clear-filter" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M12.8536 2.85355C13.0488 2.65829 13.0488 2.34171 12.8536 2.14645C12.6583 1.95118 12.3417 1.95118 12.1464 2.14645L7.5 6.79289L2.85355 2.14645C2.65829 1.95118 2.34171 1.95118 2.14645 2.14645C1.95118 2.34171 1.95118 2.65829 2.14645 2.85355L6.79289 7.5L2.14645 12.1464C1.95118 12.3417 1.95118 12.6583 2.14645 12.8536C2.34171 13.0488 2.65829 13.0488 2.85355 12.8536L7.5 8.20711L12.1464 12.8536C12.3417 13.0488 12.6583 13.0488 12.8536 12.8536C13.0488 12.6583 13.0488 12.3417 12.8536 12.1464L8.20711 7.5L12.8536 2.85355Z" fill="#4069E5"/>
                </svg>
            </button>
        `);

        clearBtn.on('click', function(e) {
            e.stopPropagation();
            const input = container.find('input[type="text"], select');

            // Input'u temizle
            input.val('').addClass('d-none');

            // X'i kaldır ve search-toggle'ı göster
            $(this).remove();
            container.find('.search-toggle').show();

            // Filtrelemeyi tetikle
            filterTable('{{ $modelName }}', '{{ $tableId }}');
        });

        container.append(clearBtn);
    }
function filterTable(modelName, tableId) {
    let filters = {};
    let hasFilter = false;

    // Input, select ve date elementlerini kontrol et
  // Mevcut input/select değerlerini topla
  $('[data-sutun]').each(function() {
    $(this).removeClass('d-none');
    $('.checkbox-dropdown').addClass('d-none');

       const element = $(this);
       const column = element.data('sutun');
        if (element.hasClass('checkbox-dropdown')) {
           // Checkbox grubu için işlem
           const checkedBoxes = element.find('input[type="checkbox"]:checked').not('.select-all');
           if (checkedBoxes.length > 0) {
               filters[column] = checkedBoxes.map(function() {
                   return $(this).val();
               }).get();
           }
       } else {
           // Normal input/select için mevcut işlem
           const value = element.val();
           if (value && value.trim() !== '') {
               filters[column] = value;
           }
       }
   });

    // Her durumda AJAX isteği gönder
    $.ajax({
        url: '{{route('filter.table')}}',
        method: 'POST',
        data: {
            filters: filters,
            model: modelName,
            relations: @json($relations),
            columnMappings: @json($columnMappings),
            where: @json($where),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            updateTable(response.data, tableId);
        },
        error: function(xhr) {
        }
    });
}
// Event listener'ları ayarla
$(document).ready(function() {
    $('input[data-sutun], select[data-sutun]').each(function() {
        $(this).removeClass('d-none');
    });
    let timeoutId;

    // Text inputlar için keyup eventi
    $('input[data-sutun]:not([type="date"])').on('change', function() {
        $('.checkbox-dropdown').addClass('d-none');

        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            filterTable('{{ $modelName }}', '{{ $tableId }}');
        }, 100);
    });

    // Select ve date elementleri için change eventi
    $('select[data-sutun], input[type="date"][data-sutun]').on('change', function() {
        $('.checkbox-dropdown').addClass('d-none');

        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            filterTable('{{ $modelName }}', '{{ $tableId }}');
        }, 100);
    });

    // Date input'lar için özel temizleme butonunu kaldır
    $('input[type="date"][data-sutun]').each(function() {
        // Varsa mevcut "Temizle" butonunu kaldır
        $(this).next('.btn-link').remove();
    });

    // Input ve select değişikliklerini izle (date inputları için özel kontrol)
    $('[data-sutun]').on('input change', function() {
        const element = $(this);
        const value = element.val();
        const isDateInput = element.attr('type') === 'date';

        if (value && value.trim() !== '') {
            // Değer varsa ve henüz X işareti yoksa ekle
            if (!element.next('.clear-filter').length) {
                addInputClearButton(element);
            }
        } else {
            // Değer yoksa X işaretini kaldır
            element.siblings('.clear-filter').remove();
        }

        // Date inputları için özel kontrol
        if (isDateInput && !value) {
            element.siblings('.clear-filter').remove();
        }
    });

    // Checkbox grupları için olay dinleyicileri
    $('.checkbox-dropdown .select-all').on('change', function() {
        const checkboxGroup = $(this).closest('.checkbox-group');
        const isChecked = $(this).prop('checked');

        // Tümü seçeneği dışındaki tüm checkbox'ları güncelle
        checkboxGroup.find('input[type="checkbox"]').not('.select-all').prop('checked', isChecked);

        // Filtrelemeyi tetikle
        triggerFilter($(this).closest('[data-sutun]'));
    });

    // Tekil checkbox'lar için olay dinleyicisi
    $('.checkbox-dropdown input[type="checkbox"]').not('.select-all').on('change', function() {
        const checkboxGroup = $(this).closest('.checkbox-group');
        const allCheckbox = checkboxGroup.find('.select-all');
        const totalCheckboxes = checkboxGroup.find('input[type="checkbox"]').not('.select-all').length;
        const checkedCheckboxes = checkboxGroup.find('input[type="checkbox"]:checked').not('.select-all').length;

        // Tümü checkbox'ını güncelle
        allCheckbox.prop('checked', totalCheckboxes === checkedCheckboxes);

        // Filtrelemeyi tetikle
        triggerFilter($(this).closest('[data-sutun]'));
    });

    // Checkbox dropdown toggle
    $('.search-toggle[data-target]').on('click', function() {
        const target = $(this).data('target');
        const container = $(this).closest('.search-field-container');
        const dropdown = container.find('.checkbox-dropdown');

        // Diğer açık dropdownları kapat
        $('.checkbox-dropdown').not(dropdown).addClass('d-none');

        // Bu dropdown'ı aç/kapat
        dropdown.toggleClass('d-none');

        // X butonunu kontrol et
        const hasCheckedBoxes = dropdown.find('input[type="checkbox"]:checked').not('.select-all').length > 0;
        if (hasCheckedBoxes) {
            if (!container.find('.clear-filter').length) {
                addClearButton(dropdown);
            }
            container.find('.clear-filter').show();
            $(this).hide();
        }
    });

    // Checkbox "Tümü" seçeneği işlemi
    $('.checkbox-dropdown .select-all').on('change', function() {
        const isChecked = $(this).prop('checked');
        const container = $(this).closest('.checkbox-dropdown');
        container.find('input[type="checkbox"]').not('.select-all').prop('checked', isChecked);

        // Filtrelemeyi tetikle
        handleCheckboxFilter(container);
    });

    // Tekil checkbox'lar için işlem
    $('.checkbox-dropdown input[type="checkbox"]').not('.select-all').on('change', function() {
        const container = $(this).closest('.checkbox-dropdown');
        const totalBoxes = container.find('input[type="checkbox"]').not('.select-all').length;
        const checkedBoxes = container.find('input[type="checkbox"]:checked').not('.select-all').length;

        // "Tümü" checkbox'ını güncelle
        container.find('.select-all').prop('checked', totalBoxes === checkedBoxes);

        // Filtrelemeyi tetikle
        handleCheckboxFilter(container);
    });

    // Sayfa dışına tıklandığında dropdown'ları kapat
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-field-container').length) {
            $('.checkbox-dropdown').addClass('d-none');
        }
    });

    // Checkbox değişikliklerini izle
    $('.checkbox-dropdown input[type="checkbox"]').on('change', function(e) {
        e.stopPropagation(); // Event'in yukarı yayılmasını engelle

        const container = $(this).closest('.search-field-container');
        const dropdown = container.find('.checkbox-dropdown');
        const selectedText = container.find('.selected-text');
        const checkedBoxes = dropdown.find('input[type="checkbox"]:checked').not('.select-all');

        // Seçili değerleri input'a yaz
        if (checkedBoxes.length > 0) {
            const selectedLabels = checkedBoxes.map(function() {
                return $(this).next('label').text();
            }).get();
            selectedText.val(selectedLabels.join(', '));
        } else {
            selectedText.val('');
        }

        // X butonunu kontrol et
        if (checkedBoxes.length > 0) {
            if (!container.find('.clear-filter').length) {
                addClearButton(dropdown);
            }
            container.find('.clear-filter').show();
            container.find('.search-toggle').hide();
        } else {
            container.find('.clear-filter').hide();
            container.find('.search-toggle').show();
        }

        // Sadece burada filtreleme yap
        filterTable('{{ $modelName }}', '{{ $tableId }}');
    });

    // Input change olayını checkbox-dropdown için devre dışı bırak
    $('.selected-text').on('change', function(e) {
        if ($(this).data('related')) {
            e.preventDefault();
            return false;
        }
    });

    // Normal input'lar için işlemler
    $('input[data-sutun]:not(.selected-text), select[data-sutun]').on('input change', function() {
        const element = $(this);
        const container = element.closest('.search-field-container');
        const value = element.val();

        // Diğer dropdown'ları kapat
        $('.checkbox-dropdown').addClass('d-none');

        if (value && value.trim() !== '') {
            element.removeClass('d-none'); // Input'u görünür yap
            container.find('.search-toggle').hide();

            // X butonunu ekle (önce varsa kaldır)
            container.find('.clear-filter').remove();
            const clearBtn = $(`
                <button class="btn btn-sm clear-filter" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M12.8536 2.85355C13.0488 2.65829 13.0488 2.34171 12.8536 2.14645C12.6583 1.95118 12.3417 1.95118 12.1464 2.14645L7.5 6.79289L2.85355 2.14645C2.65829 1.95118 2.34171 1.95118 2.14645 2.14645C1.95118 2.34171 1.95118 2.65829 2.14645 2.85355L6.79289 7.5L2.14645 12.1464C1.95118 12.3417 1.95118 12.6583 2.14645 12.8536C2.34171 13.0488 2.65829 13.0488 2.85355 12.8536L7.5 8.20711L12.1464 12.8536C12.3417 13.0488 12.6583 13.0488 12.8536 12.8536C13.0488 12.6583 13.0488 12.3417 12.8536 12.1464L8.20711 7.5L12.8536 2.85355Z" fill="#4069E5"/>
                    </svg>
                </button>
            `);

            // X'e tıklama olayı
            clearBtn.on('click', function(e) {
                e.stopPropagation();
                const input = container.find('input[data-sutun], select[data-sutun]');

                // Input'u temizle
                input.val('').addClass('d-none');

                // X'i kaldır ve search-toggle'ı göster
                $(this).remove();
                container.find('.search-toggle').show();

                // Filtrelemeyi tetikle
                filterTable('{{ $modelName }}', '{{ $tableId }}');
            });

            container.append(clearBtn);
        } else {
            container.find('.clear-filter').remove();
            container.find('.search-toggle').show();
            element.addClass('d-none'); // Input'u gizle
        }

        // Filtrelemeyi tetikle
        filterTable('{{ $modelName }}', '{{ $tableId }}');
    });

    // Search toggle click olayı
    $('.search-toggle').on('click', function(e) {
       e.stopPropagation();
       const target = $(this).data('target');
       const container = $(this).closest('.search-field-container');

       // Tüm dropdown ve input'ları kapat
       $('.form-control.checkbox-dropdown').addClass('d-none');
       //$('input[data-sutun], select[data-sutun]').addClass('d-none');

       // Eğer container'da checkbox-dropdown varsa
       if (container.find('.checkbox-dropdown').length > 0) {
           container.find('.checkbox-dropdown').removeClass('d-none');
       } else {
           // Normal input için
           container.find('input[data-sutun], select[data-sutun]').removeClass('d-none').focus();
       }
   });
});

function updateTable(data, tableId) {
    console.log('Gelen data:', data); // Debug için

    const tbody = $(`#${tableId}`);
    tbody.empty(); // Mevcut satırları temizle

    try {
        // Data array değilse ve data.data varsa, data.data'yı kullan
        const items = Array.isArray(data) ? data : (data.data || []);

        if (items && items.length > 0) {
            items.forEach(item => {
                if (typeof window.generateTableRow === 'function') {
                    const row = generateTableRow(item);
                    tbody.append(row);
                }
            });
        } else {
            // Veri yoksa bilgi mesajı göster
            tbody.append(`
                <tr>
                    <td colspan="100%" class="text-center">
                        Gösterilecek veri bulunamadı
                    </td>
                </tr>
            `);
        }
    } catch (error) {
        console.error('Tablo güncelleme hatası:', error);
        tbody.append(`
            <tr>
                <td colspan="100%" class="text-center text-danger">
                    Tablo güncellenirken bir hata oluştu
                </td>
            </tr>
        `);
    }
}

function initializeFilter(modelName, tableId) {
    let timeoutId;
    $('.checkbox-dropdown').addClass('d-none');

    $('input[data-sutun]').on('keyup', function() {

        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            filterTable(modelName, tableId);
        }, 300);
    });
}

// Aktif filtreleri güncelle
function updateActiveFilters() {
    // Select2 değerlerini topla
    $('.select2-filter').each(function() {
        const sutun = $(this).data('sutun');
        const values = $(this).val();

        if (values && values.length > 0) {
            activeFilters[sutun] = values;
        } else {
            delete activeFilters[sutun];
        }
    });

    // Normal input değerlerini topla
    $('[data-sutun]').each(function() {
        const element = $(this);
        const sutun = element.data('sutun');
        const value = element.val();

        if (value && value.trim() !== '') {
            // Okul adı için özel kontrol
            if (sutun === 'school_name') {
                // Tüm okul alanlarında arama yap
                activeFilters['school_search'] = {
                    fields: [
                        'p_school_name',
                        'm_school_name',
                        'h_school_name',
                        'current_university'
                    ],
                    value: value
                };
                delete activeFilters['school_name']; // Orijinal school_name'i temizle
            } else {
                activeFilters[sutun] = value;
            }
        } else {
            delete activeFilters[sutun];
            if (sutun === 'school_name') {
                delete activeFilters['school_search'];
            }
        }
    });

    // Checkbox gruplarını topla
    $('.multi-select').each(function() {
        const sutun = $(this).data('sutun');
        const checkedValues = [];

        $(this).find('.filter-checkbox:checked').each(function() {
            checkedValues.push($(this).val());
        });

        if (checkedValues.length > 0) {
            activeFilters[sutun] = checkedValues;
        } else {
            delete activeFilters[sutun];
        }
    });

    console.log('Aktif Filtreler:', activeFilters); // Debug için
}

// Yeni fonksiyon: Tabloyu yenileme
function refreshTable(modelName, tableId) {
    $.ajax({
        url: '/filter-table',
        method: 'POST',
        data: {
            filters: {},
            model: modelName,
            relations: @json($relations),
            columnMappings: @json($columnMappings),
            where: @json($where),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            updateTable(response.data, tableId);
        },
        error: function(xhr) {
            toastr.error('Tablo yenilenirken bir hata oluştu');
        }
    });
}

function triggerFilter(element) {
    const column = element.data('sutun');
    const checkedValues = element
        .find('input[type="checkbox"]:checked')
        .not('.select-all')
        .map(function() {
            return $(this).val();
        })
        .get();

    // Filtreleme nesnesini güncelle
    let filters = {};
    if (checkedValues.length > 0) {
        filters[column] = checkedValues;
    }

    // Filtrelemeyi çalıştır
    filterTable('{{ $modelName }}', '{{ $tableId }}', filters);
}

// Checkbox filtreleme işlemi
function handleCheckboxFilter(container) {
    const column = container.data('sutun');
    const checkedValues = container.find('input[type="checkbox"]:checked')
        .not('.select-all')
        .map(function() {
            return $(this).val();
        }).get();

    // Mevcut filters nesnesini al
    let currentFilters = {};
    $('[data-sutun]').not('.checkbox-dropdown').each(function() {
        const value = $(this).val();
        if (value && value.trim() !== '') {
            currentFilters[$(this).data('sutun')] = value;
        }
    });

    // Checkbox değerlerini ekle
    if (checkedValues.length > 0) {
        currentFilters[column] = checkedValues;
    }

    // Filtrelemeyi çalıştır
    filterTable('{{ $modelName }}', '{{ $tableId }}', currentFilters);
}
</script>
<script>

    $(document).ready(function() {
            // Normal input'lar için X butonu

        // Checkbox dropdown için özel işlemler
        $('.checkbox-dropdown input[type="checkbox"]').on('change', function() {
            const container = $(this).closest('.search-field-container');
            const dropdown = container.find('.checkbox-dropdown');
            const selectedText = container.find('.selected-text');
            const checkedBoxes = dropdown.find('input[type="checkbox"]:checked').not('.select-all');

            // Diğer tüm dropdown'ları kapat
            $('.checkbox-dropdown').not(dropdown).addClass('d-none');

            if (checkedBoxes.length > 0) {
                // Seçili değerleri göster
                const selectedLabels = checkedBoxes.map(function() {
                    return $(this).next('label').text();
                }).get();

                selectedText.val(selectedLabels.join(', '));

                // X butonunu göster
                addCheckboxClearButton(container);
                container.find('.search-toggle').hide();
            } else {
                // Seçim yoksa placeholder'ı göster
                selectedText.val('');
                container.find('.clear-filter').remove();
                container.find('.search-toggle').show();
            }
        });

        // Normal input'lar için işlemler
        $('input[type="text"]:not(.selected-text), select').on('input change', function() {
            const element = $(this);
            const container = element.closest('.search-field-container');
            const value = element.val();
            $('.checkbox-dropdown').addClass('d-none');

            if (value && value.trim() !== '') {
                container.find('.search-toggle').hide();
                addInputClearButton(container);
            } else {
                container.find('.clear-filter').remove();
                container.find('.search-toggle').show();
            }
        });
    });

    // Checkbox için X butonu
    function addCheckboxClearButton(container) {
        if (container.find('.clear-filter').length) return;

        const clearBtn = $(`
            <button class="btn btn-sm clear-filter" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M12.8536 2.85355C13.0488 2.65829 13.0488 2.34171 12.8536 2.14645C12.6583 1.95118 12.3417 1.95118 12.1464 2.14645L7.5 6.79289L2.85355 2.14645C2.65829 1.95118 2.34171 1.95118 2.14645 2.14645C1.95118 2.34171 1.95118 2.65829 2.14645 2.85355L6.79289 7.5L2.14645 12.1464C1.95118 12.3417 1.95118 12.6583 2.14645 12.8536C2.34171 13.0488 2.65829 13.0488 2.85355 12.8536L7.5 8.20711L12.1464 12.8536C12.3417 13.0488 12.6583 13.0488 12.8536 12.8536C13.0488 12.6583 13.0488 12.3417 12.8536 12.1464L8.20711 7.5L12.8536 2.85355Z" fill="#4069E5"/>
                </svg>
            </button>
        `);

        clearBtn.on('click', function(e) {
            e.stopPropagation();
            const dropdown = container.find('.checkbox-dropdown');

            // Checkbox'ları temizle
            dropdown.find('input[type="checkbox"]').prop('checked', false);
            container.find('.selected-text').val('');

            // X'i kaldır ve search-toggle'ı göster
            $(this).remove();
            container.find('.search-toggle').show();

            // Dropdown'ı kapat
            dropdown.addClass('d-none');

            // Filtrelemeyi tetikle
            filterTable('{{ $modelName }}', '{{ $tableId }}');
        });

        container.append(clearBtn);
    }



    // Panel dışına tıklama kontrolü
    $(document).mouseup(function(e) {
        const panel = $('#filterPanel');
        const select2Container = $('.select2-container');

        if (!panel.is(e.target) &&
            panel.has(e.target).length === 0 &&
            !select2Container.is(e.target) &&
            select2Container.has(e.target).length === 0 &&
            !$('#filter').is(e.target)) {

            // Input ve select elementlerini kontrol et
            let shouldHidePanel = true;

            // Text ve date inputları kontrol et
            $('input[type="text"], input[type="date"]').each(function() {
                if ($(this).val() && $(this).val().trim() !== '') {
                    shouldHidePanel = false;
                    return false; // döngüden çık
                }
            });

            // Select2 değerlerini kontrol et
            if (shouldHidePanel) {
                $('.select2-filter').each(function() {
                    if ($(this).val() && $(this).val().length > 0) {
                        shouldHidePanel = false;
                        return false; // döngüden çık
                    }
                });
            }

            // Checkbox'ları kontrol et
            if (shouldHidePanel) {
                $('.filter-checkbox:checked').each(function() {
                    shouldHidePanel = false;
                    return false; // döngüden çık
                });
            }

            // Eğer hiçbir değer yoksa paneli gizle
            if (shouldHidePanel) {
                panel.removeClass('active');
            }
        }
    });
</script>

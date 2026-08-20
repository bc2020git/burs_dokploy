<script>
// Global değişkenler
let filters = {};
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

// Filtreyi Uygula butonu için fonksiyon
function applyColumnFilter(columnName) {
    const inputElement = $(`#${columnName}_value`);
    const elementType = inputElement.length > 0 ? inputElement.attr('type') : null;
    const inputValue = inputElement.val();
    const checkedBoxes = $(`.${columnName}-check:checked`).map(function() {
        return $(this).val();
    }).get();

    // Filtre objesini oluştur
    if (!filters[columnName]) {
        filters[columnName] = {
            values: [],
            condition: $(`#${columnName}_condition`).val() || 'contains'
        };
    }
    // Input değeri varsa işle
    if (inputValue) {
        // Text ve number inputlar için badge sistemi
        if (elementType === 'text' || elementType === 'number') {
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
                inputElement.val('');
            }
        }
        // Date inputu için
        else if (elementType === 'date') {
            filters[columnName].values = [inputValue];
        }
    }

    // Checkbox değerleri varsa işle
    if (checkedBoxes.length > 0) {
        filters[columnName].values = checkedBoxes;
    }

    // Filtre değeri varsa
    if (filters[columnName] && filters[columnName].values.length > 0) {
        $(`#${columnName}_clear_filter`).removeClass('d-none');
        updateFilterIcon(columnName, true);
        if (typeof table !== 'undefined') {
            table.ajax.reload();
        }
    }
    console.log(filters);
    dropdownKapat();
}

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

        if (typeof table !== 'undefined') {
            table.ajax.reload();
        }
    }
}

// Filtre temizleme
function clearFilter(columnName) {
    $(`.${columnName}-check`).prop('checked', false);
    $(`#select_all_${columnName}`).prop('checked', false);
    $(`#${columnName}_value`).val('');
    $(`#${columnName}_condition`).val('');
    $(`#${columnName}_selected_filters`).empty();

    delete filters[columnName];
    updateFilterIcon(columnName, false);
    $(`#${columnName}_clear_filter`).addClass('d-none');

    if (typeof table !== 'undefined') {
        table.ajax.reload();
    }
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

// Dropdown kapatma
function dropdownKapat() {
    $('.dropdown-menu').removeClass('show');
}

// Sıralama işlevi
function sortColumn(columnName, direction) {
    currentSort.column = columnName;
    currentSort.direction = direction;
    if (typeof table !== 'undefined') {
        table.ajax.reload();
    }
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
            // Seçili filtreler alanındaki tüm span'ları sil
            $(`#${columnName}_selected_filters span`).remove();
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

    $(document).ready(function() {
        // Sütun görünürlüğünü kontrol etmek için
        $('.colvis-checkbox').on('change', function() {
            const columnIndex = $(this).attr('id').replace('vischk', '');
            const column = table.column(columnIndex);
            column.visible(this.checked);

        });
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

        // "Tümünü Seç/Kaldır" işlevselliği
        $('[id^="select_all_"]').on('change', function() {
            const columnName = this.id.replace('select_all_', '');
            const isChecked = $(this).prop('checked');

            // Tüm ilgili checkbox'ları güncelle
            $(`.${columnName}-check`).prop('checked', isChecked);

            // Filtreleri uygula
            applyFilters();
        });
           // Select all checkbox işlevini güncelle

    // Otomatik filtreleme olaylarını kaldır
    $('.filter-input').off('keyup keypress change');
    $('.checkbox-group input[type="checkbox"]').off('change');
    // Input'ların "keyup" event listener'ını kaldır
    $('.filter-input').off('keyup');

    // Enter tuşu ile filtreleme özelliğini kaldır
    $('.filter-input').off('keypress');
</script>

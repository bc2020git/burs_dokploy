<script>
function filterTable(modelName, tableId) {
    let filters = {};
    let hasFilter = false;

    // Input, select ve date elementlerini kontrol et
    $('input[data-sutun], select[data-sutun]').each(function() {
        const column = $(this).data('sutun');
        let value = $(this).val();

        // Element tipine göre değer kontrolü
        if ($(this).is('select')) {
            // Select elementi için boş değer kontrolü
            if (value !== '') {
                filters[column] = value;
                hasFilter = true;
            }
        } else if ($(this).attr('type') === 'date') {
            // Date elementi için değer kontrolü
            if (value) {
                filters[column] = value;
                hasFilter = true;
            }
        } else {
            // Normal input için boşluk kontrolü
            if (value && value.trim() !== '') {
                filters[column] = value;
                hasFilter = true;
            }
        }
    });

    if (!hasFilter) return;

    $.ajax({
        url: '/filter-table',
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
            toastr.error('Filtreleme sırasında bir hata oluştu');
        }
    });
}
// Event listener'ları ayarla
$(document).ready(function() {
    let timeoutId;

    // Text inputlar için keyup eventi
    $('input[data-sutun]:not([type="date"])').on('keyup', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            filterTable('{{ $modelName }}', '{{ $tableId }}');
        }, 500);
    });

    // Select ve date elementleri için change eventi
    $('select[data-sutun], input[type="date"][data-sutun]').on('change', function() {
        filterTable('{{ $modelName }}', '{{ $tableId }}');
    });
});
function updateTable(data, tableId) {
    const tbody = $(`#${tableId}`);
    tbody.empty();

    if (typeof window.generateTableRow === 'function') {
        data.forEach(item => {
            const row = generateTableRow(item);
            tbody.append(row);
        });
    }
}

function initializeFilter(modelName, tableId) {
    let timeoutId;

    $('input[data-sutun]').on('keyup', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            filterTable(modelName, tableId);
        }, 500);
    });
}
</script>
<script>
    $(document).ready(function() {
        // Arama ikonlarına tıklama olayı
        $('.search-toggle').on('click', function() {
            const target = $(this).data('target');
            const container = $(this).closest('.search-field-container');
            const input = container.find(`[data-sutun="${target}"]`);

            // Diğer tüm arama alanlarını ve ikonlarını sıfırla
            $('.form-control').addClass('d-none');
            $('.search-toggle').removeClass('active');

            // Tıklanan alanı göster/gizle
            input.toggleClass('d-none');
            $(this).toggleClass('active');
            $(this).addClass('d-none');
            // Input görünürse focus yap
            if (!input.hasClass('d-none')) {
                input.focus();
            }
        });

        // ESC tuşuna basıldığında tüm arama alanlarını gizle
        $(document).on('keyup', function(e) {
            if (e.key === "Escape") {
                $('.form-control').addClass('d-none');
                $('.search-toggle').removeClass('active');
                $('.search-toggle').removeClass('d-none');
            }
        });

        // Input dışında bir yere tıklandığında
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-field-container').length) {
                $('.form-control').addClass('d-none');
                $('.search-toggle').removeClass('active');
                $('.search-toggle').removeClass('d-none');
            }
        });
    });
</script>

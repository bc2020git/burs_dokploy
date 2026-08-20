{{-- Export Buttons Component --}}
<div class="dropdown" id='exportActionDropdown'>
    <button class="btn btn-primary dropdown-toggle export-action-main-button" type="button" id="exportDropdown{{ $tableId }}" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-download"></i> Dışa Aktar
    </button>
    <ul class="dropdown-menu" aria-labelledby="exportDropdown{{ $tableId }}">
        <li>
            <a class="dropdown-item export-action" href="#"
               data-format="excel"
               data-table="{{ $tableId }}"
               data-model="{{ $model }}">
               <img src="../assets/images/excel.svg" alt="Excel" width="24" height="24">
               Excel dosyasında aktar

                        </a>
        </li>
        <li>
            <a class="dropdown-item export-action" href="#"
               data-format="pdf"
               data-table="{{ $tableId }}"
               data-model="{{ $model }}">
               <img src="../assets/images/pdf.svg" alt="Excel" width="24" height="24">
               PDF olarak aktar

                        </a>
            </a>
        </li>
        <li>
            <a class="dropdown-item export-action" href="#"
               data-format="csv"
               data-table="{{ $tableId }}"
               data-model="{{ $model }}">
               <img src="../assets/images/csv.svg" alt="Excel" width="24" height="24">
               .csv olarak aktar
            </a>
        </li>
        <li id="topluIndirBtn" ><a class="dropdown-item" href="#">
            <img src="../assets/images/excel.svg" alt="Toplu Aktar" width="24" height="24">
            Toplu Aktar
        </a>
    </li>
        </ul>
</div>

{{-- Tamamen yeni export handler --}}
<script type="text/javascript">
(function() {
    'use strict';

    const tableId = '{{ $tableId }}';
    const handlerKey = 'exportHandler_' + tableId + '_' + Date.now();

    console.log('🎯 Initializing export for table:', tableId);

    let isExporting = false;

    function initExportHandlers() {
        // Mevcut tüm event listener'ları temizle
        const buttons = document.querySelectorAll('.export-action[data-table="' + tableId + '"]');
        console.log('🎛️ Found export buttons:', buttons.length);

        buttons.forEach(button => {
            // Clone to remove all event listeners
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);

            // Add new click handler
            newButton.addEventListener('click', function(e) {
                handleExportClick(e, this);
            }, { capture: true, once: false });
        });
    }

    function handleExportClick(e, button) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        if (isExporting) {
            console.log('⏳ Export in progress, ignoring click');
            return false;
        }

        isExporting = true;

        const format = button.getAttribute('data-format');
        const tableId = button.getAttribute('data-table');

        console.log('📤 Starting export:', { format, tableId });

        // Button state
        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> İşleniyor...';

        // Perform export
        setTimeout(() => {
            try {
                performDataTablesExport(format, tableId);
            } catch (error) {
                console.error('❌ Export failed:', error);
            }

            // Reset after delay
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = originalText;
                isExporting = false;
                console.log('✅ Export completed');
            }, 3000);
        }, 100);

        return false;
    }

    function performDataTablesExport(format, tableId) {
        // Method 1: Global table variable
        if (typeof table !== 'undefined' && table && table.button) {
            const buttonIndex = getButtonIndex(format);
            if (buttonIndex !== null) {
                console.log('🔄 Using global table, button index:', buttonIndex);
                table.button(buttonIndex).trigger();
                return;
            }
        }

        // Method 2: jQuery DataTable instance
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            const $table = $('#' + tableId);
            if ($table.length && $.fn.DataTable.isDataTable($table)) {
                const dt = $table.DataTable();
                const buttonIndex = getButtonIndex(format);
                if (buttonIndex !== null && dt.button && dt.button(buttonIndex)) {
                    console.log('🔄 Using jQuery DataTable, button index:', buttonIndex);
                    dt.button(buttonIndex).trigger();
                    return;
                }
            }
        }

        console.log('❌ No DataTable export method available');
    }

    function getButtonIndex(format) {
        switch(format) {
            case 'excel': return 0;
            case 'pdf': return 1;
            case 'csv': return 2;
            default: return null;
        }
    }

    // Initialize when ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initExportHandlers);
    } else {
        setTimeout(initExportHandlers, 200);
    }

})();
</script>

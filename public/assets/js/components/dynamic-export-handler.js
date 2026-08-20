/**
 * Dinamik Export Handler - Tüm tanimlar tabloları için
 * Her tablo için ayrı export işlevselliği sağlar
 */

// Dosya yüklendiğinde console'a mesaj yazdır
console.log('🚀 Dynamic Export Handler loaded successfully!');
console.log('📅 Loaded at:', new Date().toLocaleTimeString());

// Global export handler fonksiyonu
function initializeDynamicExport(tableId) {
    console.log('🚀 Initializing Dynamic Export Handler for table:', tableId);

    // Table'ın var olup olmadığını kontrol et
    const table = document.getElementById(tableId);
    if (!table) {
        console.error('❌ Table not found:', tableId);
        console.log('Available tables:', document.querySelectorAll('table[id]'));
        return;
    }

    // Export butonlarının var olup olmadığını kontrol et
    const exportButtons = document.querySelectorAll(`.export-action[data-table="${tableId}"]`);
    console.log('📊 Found export buttons for', tableId, ':', exportButtons.length);

    if (exportButtons.length === 0) {
        console.warn('⚠️ No export buttons found for table:', tableId);
        return;
    }

    // Export action butonlarına event listener ekle
    document.addEventListener('click', function(e) {
        if (e.target.closest('.export-action')) {
            const button = e.target.closest('.export-action');
            const buttonTable = button.getAttribute('data-table');

            // Sadece bu table için olan butonlara tepki ver
            if (buttonTable === tableId) {
                console.log('🖱️ Export button clicked for table:', tableId);
                e.preventDefault();
                handleDynamicExport(button);
            }
        }
    });

    console.log('✅ Dynamic Export Handler initialized for:', tableId);
}

function handleDynamicExport(element) {
    const format = element.getAttribute('data-format');
    const tableId = element.getAttribute('data-table');
    const model = element.getAttribute('data-model');

    console.log('📤 Export clicked:', { format, tableId, model });

    // Seçili kayıtları kontrol et (opsiyonel - DataTables kendi filtering'ini yapacak)
    const selectedItems = getSelectedItems(tableId);
    console.log('📋 Selected items:', selectedItems.length, 'items');

    // Tamamen DataTables export'unu kullan
    console.log('🔄 Using DataTables client-side export...');
    if (tryDataTablesExport(tableId, format)) {
        console.log('✅ DataTables export successful');
        return;
    }

    // Eğer DataTables export çalışmazsa alternatif yöntem
    console.log('⚠️ DataTables export failed, trying alternative...');
    tryAlternativeClientSideExport(tableId, format);
}

function tryDataTablesExport(tableId, format) {
    try {
        console.log('🔍 Looking for DataTables instance for:', tableId);

        // 1. Global table değişkenini kontrol et
        if (typeof table !== 'undefined' && table) {
            console.log('✅ Found global DataTables instance');
            return triggerDataTablesButton(table, format, 'global');
        }

        // 2. jQuery DataTables instance'ını dene
        if (typeof $ !== 'undefined' && $.fn.DataTable) {
            const $table = $('#' + tableId);
            if ($table.length && $.fn.DataTable.isDataTable($table)) {
                const dtInstance = $table.DataTable();
                console.log('✅ Found jQuery DataTables instance');
                return triggerDataTablesButton(dtInstance, format, 'jquery');
            }
        }

        // 3. Window üzerindeki diğer table instance'larını ara
        const possibleTables = ['table', 'tables', 'districtTable', 'provinceTable'];
        for (let tableName of possibleTables) {
            if (typeof window[tableName] !== 'undefined' && window[tableName]) {
                console.log('✅ Found window table instance:', tableName);
                if (triggerDataTablesButton(window[tableName], format, tableName)) {
                    return true;
                }
            }
        }

        console.log('❌ No DataTables instance found');
        return false;

    } catch (error) {
        console.error('❌ Error in DataTables export:', error);
        return false;
    }
}

function triggerDataTablesButton(tableInstance, format, source) {
    try {
        let buttonSelector;
        switch(format) {
            case 'excel':
                buttonSelector = '.buttons-excel';
                break;
            case 'pdf':
                buttonSelector = '.buttons-pdf';
                break;
            case 'csv':
                buttonSelector = '.buttons-csv';
                break;
            default:
                console.log('❌ Unsupported format:', format);
                return false;
        }

        console.log(`🔄 Trying to trigger ${buttonSelector} from ${source}`);

        // Button'ı bul ve tetikle
        const button = tableInstance.button(buttonSelector);
        if (button && button.node) {
            const buttonNode = button.node();
            if (buttonNode) {
                console.log('✅ Found button node, triggering...');
                button.trigger();
                return true;
            }
        }

        // Alternatif: DOM'dan button'ı bul
        const domButton = document.querySelector(buttonSelector);
        if (domButton) {
            console.log('✅ Found DOM button, clicking...');
            domButton.click();
            return true;
        }

        console.log('❌ Button not found:', buttonSelector);
        return false;

    } catch (error) {
        console.error('❌ Error triggering button:', error);
        return false;
    }
}

function tryAlternativeClientSideExport(tableId, format) {
    console.log('🔄 Trying alternative client-side export...');

    try {
        // Legacy button ID'lerini dene
        const legacyButtonIds = {
            'excel': ['excelButton', 'excel-btn', 'btn-excel'],
            'pdf': ['pdfButton', 'pdf-btn', 'btn-pdf'],
            'csv': ['csvButton', 'csv-btn', 'btn-csv']
        };

        const buttonIds = legacyButtonIds[format] || [];

        for (let buttonId of buttonIds) {
            const button = document.getElementById(buttonId);
            if (button) {
                console.log('✅ Found legacy button:', buttonId);
                button.click();
                return true;
            }
        }

        // DOM'da hidden butonları ara
        const hiddenButtons = document.querySelectorAll('.buttons-' + format + ', .dt-button-' + format);
        if (hiddenButtons.length > 0) {
            console.log('✅ Found hidden button:', hiddenButtons[0]);
            hiddenButtons[0].click();
            return true;
        }

        // Manual export işlemi (basit CSV export)
        if (format === 'csv') {
            console.log('🔄 Trying manual CSV export...');
            return manualCSVExport(tableId);
        }

        console.log('❌ No alternative export method found');
        showExportError(`${format.toUpperCase()} export için uygun yöntem bulunamadı. DataTables export extension'ı yüklü olduğundan emin olun.`);
        return false;

    } catch (error) {
        console.error('❌ Error in alternative export:', error);
        showExportError('Export işlemi sırasında hata oluştu: ' + error.message);
        return false;
    }
}

function manualCSVExport(tableId) {
    try {
        const table = document.getElementById(tableId);
        if (!table) {
            console.log('❌ Table not found for manual export');
            return false;
        }

        console.log('📊 Starting manual CSV export...');

        // Tablo verilerini al
        const rows = table.querySelectorAll('tbody tr');
        const headers = table.querySelectorAll('thead th');

        let csvContent = '';

        // Başlıkları ekle
        const headerRow = [];
        headers.forEach(header => {
            const text = header.textContent.trim();
            if (text && text !== '' && !text.includes('checkbox')) {
                headerRow.push('"' + text.replace(/"/g, '""') + '"');
            }
        });
        csvContent += headerRow.join(',') + '\n';

        // Veri satırlarını ekle
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowData = [];

            cells.forEach((cell, index) => {
                // Checkbox kolonunu atla
                if (!cell.querySelector('input[type="checkbox"]')) {
                    const text = cell.textContent.trim();
                    rowData.push('"' + text.replace(/"/g, '""') + '"');
                }
            });

            if (rowData.length > 0) {
                csvContent += rowData.join(',') + '\n';
            }
        });

        // CSV dosyasını indir
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `${tableId}_export_${new Date().toISOString().slice(0,10)}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        console.log('✅ Manual CSV export completed');
        showExportSuccess('CSV dosyası başarıyla oluşturuldu');
        return true;

    } catch (error) {
        console.error('❌ Error in manual CSV export:', error);
        return false;
    }
}

function getSelectedItems(tableId) {
    const selectedItems = [];

    console.log('🔍 Looking for checkboxes in table:', tableId);

    // Seçili checkbox'ları bul
    const checkboxes = document.querySelectorAll(`#${tableId} .user-checkbox:checked`);
    console.log('✅ Found checked checkboxes:', checkboxes.length);

    // Eğer hiç checkbox yoksa, tüm checkbox'ları kontrol et
    if (checkboxes.length === 0) {
        const allCheckboxes = document.querySelectorAll(`#${tableId} .user-checkbox`);
        console.log('📋 Total checkboxes found:', allCheckboxes.length);

        if (allCheckboxes.length === 0) {
            console.warn('⚠️ No checkboxes found with class .user-checkbox in table:', tableId);
            // Alternatif checkbox class'larını dene
            const altCheckboxes = document.querySelectorAll(`#${tableId} input[type="checkbox"]`);
            console.log('🔄 Alternative checkboxes found:', altCheckboxes.length);
        }
    }

    checkboxes.forEach((checkbox, index) => {
        const itemId = checkbox.getAttribute('data-id') || checkbox.value;
        console.log(`📦 Checkbox ${index + 1}:`, {
            id: itemId,
            dataId: checkbox.getAttribute('data-id'),
            value: checkbox.value,
            checked: checkbox.checked
        });

        if (itemId) {
            selectedItems.push(itemId);
        }
    });

    console.log('📤 Selected items for export:', selectedItems);
    return selectedItems;
}

// UI Yardımcı Fonksiyonları
function showExportLoading() {
    // Basit loading göstergesi
    if (!document.getElementById('export-loading')) {
        const loading = document.createElement('div');
        loading.id = 'export-loading';
        loading.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                        background: rgba(0,0,0,0.5); z-index: 9999; display: flex;
                        align-items: center; justify-content: center;">
                <div style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Yükleniyor...</span>
                    </div>
                    <div style="margin-top: 10px;">Dışa aktarılıyor...</div>
                </div>
            </div>
        `;
        document.body.appendChild(loading);
    }
}

function hideExportLoading() {
    const loading = document.getElementById('export-loading');
    if (loading) {
        loading.remove();
    }
}

function showExportSuccess(message) {
    showNotification(message, 'success');
}

function showExportError(message) {
    showNotification(message, 'error');
}

function showExportWarning(message) {
    showNotification(message, 'warning');
}

function showNotification(message, type = 'info') {
    // iziToast kullanılabiliyorsa onu kullan
    if (typeof iziToast !== 'undefined') {
        iziToast[type]({
            title: type === 'success' ? 'Başarılı' : type === 'error' ? 'Hata' : 'Bilgi',
            message: message,
            position: 'topRight'
        });
    } else {
        // Fallback: basit alert
        alert(message);
    }
}

// Global fonksiyonu tanımla
window.initializeDynamicExport = initializeDynamicExport;

/**
 * Legacy Export Handler - Backward compatibility için
 * Yeni projeler için dynamic-export-handler.js kullanın
 */
class ExportHandler {
    constructor(tableId) {
        console.log('Legacy ExportHandler initialized for table:', tableId);
        this.tableId = tableId;
        this.table = document.getElementById(tableId);

        // Yeni dinamik export handler'ı başlat
        if (typeof initializeDynamicExport === 'function') {
            initializeDynamicExport(tableId);
            console.log('Switched to dynamic export handler');
            return;
        }

        // Fallback: eski yöntem
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        if (!this.table) {
            console.error('Table element not found:', this.tableId);
            return;
        }

        console.log('Setting up legacy event listeners for export menu items');
        const menuItems = document.querySelectorAll(`#export-menu-${this.tableId} .dropdown-item`);
        console.log('Found export menu items:', menuItems.length);

        menuItems.forEach(item => {
            console.log('Adding click listener to menu item:', item.textContent);
            item.addEventListener('click', (e) => {
                console.log('Export menu item clicked:', e.target.textContent);
                this.handleExport(e);
            });
        });
    }

    handleExport(event) {
        event.preventDefault();
        const menuItem = event.target.closest('.dropdown-item');
        console.log('Export menu item found:', menuItem);

        const format = menuItem.getAttribute('data-format');
        console.log('Export format:', format);

        // Önce DataTables butonlarını dene
        if (this.tryDataTablesExport(format)) {
            return;
        }

        // DataTables başarısız olursa eski yöntem
        this.tryLegacyButtons(format);
    }

    tryDataTablesExport(format) {
        try {
            // Global table değişkenini kontrol et
            if (typeof table !== 'undefined' && table) {
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
                        return false;
                }

                const button = table.button(buttonSelector);
                if (button && button.node()) {
                    console.log('Triggering DataTables export button:', buttonSelector);
                    button.trigger();
                    return true;
                }
            }
            return false;
        } catch (error) {
            console.error('Error in DataTables export:', error);
            return false;
        }
    }

    tryLegacyButtons(format) {
        // Legacy button ID'leri
        let buttonId;
        switch(format) {
            case 'excel':
                buttonId = 'excelButton';
                break;
            case 'pdf':
                buttonId = 'pdfButton';
                break;
            case 'csv':
                buttonId = 'csvButton';
                break;
        }

        console.log('Looking for legacy button with ID:', buttonId);
        const button = document.getElementById(buttonId);

        if (button) {
            console.log('Found legacy export button, triggering click');
            button.click();
        } else {
            console.error('Export button not found:', buttonId);
            console.log('Available export methods exhausted');
        }
    }
}

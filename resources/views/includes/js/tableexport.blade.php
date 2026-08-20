buttons: [
                {
                    extend: 'csv',
                    text: 'CSV olarak al',
                    action: function(e, dt, button, config) {
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
                        console.log("Seçili checkbox sayısı:", selectedCheckboxes.length);

                        // Sadece mevcut sayfadaki verileri al
                        let currentPageData = dt.rows({ page: 'current' }).data().toArray();
                        console.log("Mevcut sayfadaki satır sayısı:", currentPageData.length);

                        // Seçili satırları veya tüm mevcut sayfa verilerini filtrele
                        let exportData = currentPageData;
                        if (selectedCheckboxes.length > 0) {
                            exportData = currentPageData.filter(row => {
                                const rowId = row[2]; // ID sütunu
                                return Array.from(selectedCheckboxes).some(checkbox => checkbox.value === rowId);
                            });
                        }

                        // Geçici bir tablo oluştur ve sadece filtrelenmiş verileri içine koy
                        let tempTable = $('<table>').append(
                            dt.table().header().cloneNode(true)
                        );
                        let tempDt = $(tempTable).DataTable({
                            data: exportData,
                            columns: dt.settings()[0].aoColumns
                        });

                        // Export işlemini geçici tablo üzerinden yap
                        config.exportOptions = {
                            modifier: {
                                page: 'all' // Geçici tabloda zaten sadece istediğimiz veriler var
                            }
                        };

                        // CSV export'u çalıştır
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(
                            this,
                            e,
                            tempDt,
                            button,
                            config
                        );

                        // Geçici tabloyu temizle
                        tempDt.destroy();
                        $(tempTable).remove();
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel olarak al',
                    action: function(e, dt, button, config) {
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                        let currentPageData = dt.rows({ page: 'current' }).data().toArray();
                        let exportData = currentPageData;
                        if (selectedCheckboxes.length > 0) {
                            exportData = currentPageData.filter(row => {
                                const rowId = row[2];
                                return Array.from(selectedCheckboxes).some(checkbox => checkbox.value === rowId);
                            });
                        }

                        let tempTable = $('<table>').append(
                            dt.table().header().cloneNode(true)
                        );
                        let tempDt = $(tempTable).DataTable({
                            data: exportData,
                            columns: dt.settings()[0].aoColumns
                        });

                        config.exportOptions = {
                            modifier: {
                                page: 'all'
                            }
                        };

                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(
                            this,
                            e,
                            tempDt,
                            button,
                            config
                        );

                        tempDt.destroy();
                        $(tempTable).remove();
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF olarak al',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    action: function(e, dt, button, config) {
                        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

                        let currentPageData = dt.rows({ page: 'current' }).data().toArray();
                        let exportData = currentPageData;
                        if (selectedCheckboxes.length > 0) {
                            exportData = currentPageData.filter(row => {
                                const rowId = row[2];
                                return Array.from(selectedCheckboxes).some(checkbox => checkbox.value === rowId);
                            });
                        }

                        let tempTable = $('<table>').append(
                            dt.table().header().cloneNode(true)
                        );
                        let tempDt = $(tempTable).DataTable({
                            data: exportData,
                            columns: dt.settings()[0].aoColumns
                        });

                        config.exportOptions = {
                            modifier: {
                                page: 'all'
                            }
                        };

                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(
                            this,
                            e,
                            tempDt,
                            button,
                            config
                        );

                        tempDt.destroy();
                        $(tempTable).remove();
                    }
                }
            ]

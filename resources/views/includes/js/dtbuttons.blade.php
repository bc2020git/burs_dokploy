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
    }
],

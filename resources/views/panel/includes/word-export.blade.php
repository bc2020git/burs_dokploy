<script>
    $('#wordExport').click(function(){
        exportToWord();
    });
function exportToWord() {
    var table = $({{$tableId}}).DataTable();

    // Sayfa başlığını ve tarihi al
    var pageTitle = document.title.replace(/[^a-z0-9]/gi, '_').toLowerCase(); // Geçersiz karakterleri _ ile değiştir
    var today = new Date();
    var date = today.getFullYear() + '_' +
               String(today.getMonth() + 1).padStart(2, '0') + '_' +
               String(today.getDate()).padStart(2, '0');
    var fileName = pageTitle + '_' + date + '.doc';

    // Görünür sütunları bul (checkbox hariç ilk 8 görünür sütun)
    var visibleColumns = [];
    var visibleCount = 0;

    table.columns().every(function(index) {
        if (this.visible() && index > 0) { // checkbox sütununu atla
            visibleColumns.push(index);
            visibleCount++;
            if (visibleCount >= 8) {
                return false; // İlk 8 görünür sütun bulununca dur
            }
        }
    });

    // Başlıkları al
    var headers = [];
    visibleColumns.forEach(function(colIndex) {
        var $th = $(table.column(colIndex).header());
        var headerText = $th.find('.filter-column-title').text().trim();
        if (headerText) {
            headers.push(headerText);
        }
    });

    // Satır verilerini al
    var rows = [];
    var selectedRows = $('.checkbox:checked');

    if (selectedRows.length > 0) {
        // Sadece seçili satırları al
        table.rows().every(function(rowIdx) {
            var $row = $(this.node());
            if ($row.find('.checkbox').prop('checked')) {
                var rowData = [];
                visibleColumns.forEach(function(colIndex) {
                    var cellData = table.cell(rowIdx, colIndex).data();
                    rowData.push($('<div>').html(cellData).text().trim() || '');
                });
                rows.push(rowData);
            }
        });
    } else {
        // Tüm satırları al
        table.rows().every(function(rowIdx) {
            var rowData = [];
            visibleColumns.forEach(function(colIndex) {
                var cellData = table.cell(rowIdx, colIndex).data();
                rowData.push($('<div>').html(cellData).text().trim() || '');
            });
            rows.push(rowData);
        });
    }

    // Word dokümanı oluştur
    var docContent = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">';
    docContent += '<head>';
    docContent += '<meta charset="utf-8">';
    docContent += '<title>' + document.title + '</title>';
    // A3 sayfa boyutu için stil ekle
    docContent += '<style>';
    docContent += '@page Section1 {size:297mm 420mm; margin:20mm 20mm 20mm 20mm; mso-page-orientation:landscape;}';
    docContent += 'div.Section1 {page:Section1;}';
    docContent += 'table {width:100%; border-collapse:collapse;}';
    docContent += 'td, th {border:1px solid black; padding:5px;}';
    docContent += '</style>';
    docContent += '</head>';

    docContent += '<body>';
    docContent += '<div class="Section1">'; // A3 boyutu için div wrapper

    docContent += '<table>';

    // Başlıkları ekle
    docContent += '<tr style="background-color: #f2f2f2; font-weight: bold;">';
    headers.forEach(function(header) {
        docContent += '<th style="text-align: center;">' + header + '</th>';
    });
    docContent += '</tr>';

    // Satırları ekle
    rows.forEach(function(row, index) {
        docContent += '<tr' + (index % 2 ? ' style="background-color: #f9f9f9;"' : '') + '>';
        row.forEach(function(cell) {
            docContent += '<td>' + (cell || '') + '</td>';
        });
        docContent += '</tr>';
    });

    docContent += '</table>';
    docContent += '</div>'; // Section1 div'ini kapat
    docContent += '</body></html>';

    var blob = new Blob([docContent], {
        type: 'application/msword'
    });
    var url = URL.createObjectURL(blob);
    var link = document.createElement('a');
    link.href = url;
    link.download = fileName; // Dinamik dosya adını kullan
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}
</script>

<?php

namespace App\Services;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportService
{
    protected $data;
    protected $columns;
    protected $fileName;

    public function __construct(Collection $data, array $columns, string $fileName)
    {
        $this->data = $data;
        $this->columns = $columns;
        $this->fileName = $fileName;
    }

    public function toCsv()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Başlıkları yaz
        foreach ($this->columns as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        // Verileri yaz
        $row = 2;
        foreach ($this->data as $item) {
            $col = 1;
            foreach ($this->columns as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $sheet->setCellValue($column . $row, $item->$key ?? '');
                $col++;
            }
            $row++;
        }

        // CSV dosyasını oluştur
        $writer = new Csv($spreadsheet);
        $fileName = $this->fileName . '.csv';
        $filePath = storage_path('app/public/temp/' . $fileName);

        // Temp klasörünü kontrol et
        if (!file_exists(storage_path('app/public/temp'))) {
            mkdir(storage_path('app/public/temp'), 0777, true);
        }

        // Dosyayı kaydet
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function toExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Başlıkları yaz
        foreach ($this->columns as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        // Verileri yaz
        $row = 2;
        foreach ($this->data as $item) {
            $col = 1;
            foreach ($this->columns as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $sheet->setCellValue($column . $row, $item->$key ?? '');
                $col++;
            }
            $row++;
        }

        // Excel dosyasını oluştur
        $writer = new Xlsx($spreadsheet);
        $fileName = $this->fileName . '.xlsx';
        $filePath = storage_path('app/public/temp/' . $fileName);

        // Temp klasörünü kontrol et
        if (!file_exists(storage_path('app/public/temp'))) {
            mkdir(storage_path('app/public/temp'), 0777, true);
        }

        // Dosyayı kaydet
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function toPdf()
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);

        $html = '<html><head>';
        $html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= '<style>
            table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f5f5f5; }
        </style>';
        $html .= '</head><body>';

        $html .= '<table>';
        $html .= '<thead><tr>';
        foreach ($this->columns as $column) {
            $html .= '<th>' . $column . '</th>';
        }
        $html .= '</tr></thead>';

        $html .= '<tbody>';
        foreach ($this->data as $item) {
            $html .= '<tr>';
            foreach ($this->columns as $key => $column) {
                $html .= '<td>' . ($item->$key ?? '') . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        $html .= '</body></html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $fileName = $this->fileName . '.pdf';
        $filePath = storage_path('app/public/temp/' . $fileName);

        // Temp klasörünü kontrol et
        if (!file_exists(storage_path('app/public/temp'))) {
            mkdir(storage_path('app/public/temp'), 0777, true);
        }

        // PDF'i kaydet
        file_put_contents($filePath, $dompdf->output());

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}

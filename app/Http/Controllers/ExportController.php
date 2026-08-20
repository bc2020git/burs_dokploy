<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{
    public function export(Request $request, $model, $format)
    {
        try {
            // Input validation
            $items = json_decode($request->input('items', '[]'), true);

            if (!is_array($items) || empty($items)) {
                return response()->json(['error' => 'Geçerli öğe seçimi yapılmadı'], 400);
            }

            // Model sınıfını dinamik olarak yükle ve doğrula
            $modelClass = $this->getModelClass($model);
            if (!$modelClass) {
                return response()->json(['error' => 'Geçersiz model'], 400);
            }

            // Kayıtları al
            $records = $modelClass::whereIn('id', $items)->get();

            if ($records->isEmpty()) {
                return response()->json(['error' => 'Kayıt bulunamadı'], 404);
            }

            // Format'a göre export işlemi
            switch (strtolower($format)) {
                case 'excel':
                    return $this->exportToExcel($records, $model);
                case 'csv':
                    return $this->exportToCsv($records, $model);
                case 'pdf':
                    return $this->exportToPdf($records, $model);
                default:
                    return response()->json(['error' => 'Desteklenmeyen format: ' . $format], 400);
            }

        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage(), [
                'model' => $model,
                'format' => $format,
                'items' => $request->input('items')
            ]);

            return response()->json(['error' => 'Export işlemi sırasında hata oluştu'], 500);
        }
    }

    private function getModelClass($model)
    {
        // Güvenlik için izin verilen modelleri kontrol et
                $allowedModels = [
            'district' => 'App\\Models\\District',
            'province' => 'App\\Models\\Il',
            'il' => 'App\\Models\\Il',
            'ilce' => 'App\\Models\\District',
            'bank' => 'App\\Models\\Bank',
            'banka' => 'App\\Models\\Bank',
            'university' => 'App\\Models\\Universite',
            'universite' => 'App\\Models\\Universite',
            'universities' => 'App\\Models\\Universite',
            'faculty' => 'App\\Models\\Fakulte',
            'fakulte' => 'App\\Models\\Fakulte',
            'faculties' => 'App\\Models\\Fakulte',
            'department' => 'App\\Models\\Bolum',
            'bolum' => 'App\\Models\\Bolum',
            'departments' => 'App\\Models\\Bolum',
            'departmants' => 'App\\Models\\Bolum',
            'bursTipi' => 'App\\Models\\BursTipi',
            'burstipi' => 'App\\Models\\BursTipi',
            'question' => 'App\\Models\\Question',
            'soru' => 'App\\Models\\Question',
            'questioncategory' => 'App\\Models\\QuestionCategory',
            'sorukategori' => 'App\\Models\\QuestionCategory',
            'messagetemplate' => 'App\\Models\\MessageTemplate',
            'mesajsablon' => 'App\\Models\\MessageTemplate',
            'sebep' => 'App\\Models\\Sebep',
            'reason' => 'App\\Models\\Sebep'
        ];

        $modelKey = strtolower($model);

        if (isset($allowedModels[$modelKey])) {
            $className = $allowedModels[$modelKey];
            if (class_exists($className)) {
                return $className;
            }
        }

        return null;
    }

    private function exportToExcel($records, $modelName)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if ($records->isEmpty()) {
            throw new \Exception('Dışa aktarılacak kayıt bulunamadı');
        }

        // Başlıkları ayarla - Türkçe başlıklar için mapping
        $columnMappings = $this->getColumnMappings($modelName);
        $columns = array_keys($records->first()->toArray());

        foreach ($columns as $index => $column) {
            $header = $columnMappings[$column] ?? ucfirst(str_replace('_', ' ', $column));
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
        }

        // Başlık satırını kalın yap
        $sheet->getStyle('1:1')->getFont()->setBold(true);

        // Verileri doldur
        foreach ($records as $rowIndex => $record) {
            $data = $record->toArray();
            foreach ($data as $columnIndex => $value) {
                $columnPosition = array_search($columnIndex, $columns) + 1;
                $sheet->setCellValueByColumnAndRow(
                    $columnPosition,
                    $rowIndex + 2,
                    $this->formatCellValue($value)
                );
            }
        }

        // Sütun genişliklerini otomatik ayarla
        foreach ($columns as $index => $column) {
            $sheet->getColumnDimensionByColumn($index + 1)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = $this->generateFilename($modelName, 'xlsx');

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
            ]
        );
    }

    private function exportToCsv($records, $modelName)
    {
        if ($records->isEmpty()) {
            throw new \Exception('Dışa aktarılacak kayıt bulunamadı');
        }

        $columnMappings = $this->getColumnMappings($modelName);
        $columns = array_keys($records->first()->toArray());
        $filename = $this->generateFilename($modelName, 'csv');

        return response()->stream(
            function () use ($records, $columns, $columnMappings) {
                $handle = fopen('php://output', 'w');

                // UTF-8 BOM ekle (Excel'de Türkçe karakterler için)
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

                // Başlıkları yaz
                $headers = [];
                foreach ($columns as $column) {
                    $headers[] = $columnMappings[$column] ?? ucfirst(str_replace('_', ' ', $column));
                }
                fputcsv($handle, $headers, ';');

                // Verileri yaz
                foreach ($records as $record) {
                    $row = [];
                    foreach ($columns as $column) {
                        $row[] = $this->formatCellValue($record->$column);
                    }
                    fputcsv($handle, $row, ';');
                }

                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
            ]
        );
    }

    private function exportToPdf($records, $modelName)
    {
        if ($records->isEmpty()) {
            throw new \Exception('Dışa aktarılacak kayıt bulunamadı');
        }

        $columnMappings = $this->getColumnMappings($modelName);
        $columns = array_keys($records->first()->toArray());

        $html = View::make('exports.pdf-template', [
            'records' => $records,
            'columns' => $columns,
            'columnMappings' => $columnMappings,
            'modelName' => $modelName,
            'title' => $this->getModelTitle($modelName)
        ])->render();

        $dompdf = new Dompdf(['enable_font_subsetting' => false]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = $this->generateFilename($modelName, 'pdf');

        return $dompdf->stream($filename, ['Attachment' => true]);
    }

        private function getColumnMappings($modelName)
    {
        $mappings = [
            'district' => [
                'id' => 'ID',
                'name' => 'İlçe Adı',
                'il_id' => 'İl ID',
                'plaka_kodu' => 'Plaka Kodu',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi'
            ],
            'il' => [
                'id' => 'ID',
                'name' => 'İl Adı',
                'plaka' => 'Plaka Kodu',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi'
            ],
            'province' => [
                'id' => 'ID',
                'name' => 'İl Adı',
                'plaka' => 'Plaka Kodu',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi'
            ],
            'university' => [
                'id' => 'ID',
                'name' => 'Üniversite Adı',
                'city' => 'Şehir',
                'type' => 'Tür',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi'
            ],
            'faculty' => [
                'id' => 'ID',
                'name' => 'Fakülte Adı',
                'university_id' => 'Üniversite ID',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi'
            ],
            'department' => [
                'id' => 'ID',
                'name' => 'Bölüm Adı',
                'faculty_id' => 'Fakülte ID',
                'university_id' => 'Üniversite ID',
                'created_at' => 'Oluşturulma Tarihi',
                'updated_at' => 'Güncellenme Tarihi'
            ]
        ];

        return $mappings[strtolower($modelName)] ?? [];
    }

        private function getModelTitle($modelName)
    {
        $titles = [
            'district' => 'İlçeler',
            'il' => 'İller',
            'province' => 'İller',
            'bank' => 'Bankalar',
            'university' => 'Üniversiteler',
            'universities' => 'Üniversiteler',
            'universite' => 'Üniversiteler',
            'faculty' => 'Fakülteler',
            'faculties' => 'Fakülteler',
            'fakulte' => 'Fakülteler',
            'department' => 'Bölümler',
            'departments' => 'Bölümler',
            'departmants' => 'Bölümler',
            'bolum' => 'Bölümler'
        ];

        return $titles[strtolower($modelName)] ?? ucfirst($modelName);
    }

    private function generateFilename($modelName, $extension)
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $title = $this->getModelTitle($modelName);

        return "{$title}_Export_{$timestamp}.{$extension}";
    }

    private function formatCellValue($value)
    {
        if (is_null($value)) {
            return '';
        }

        if (is_bool($value)) {
            return $value ? 'Evet' : 'Hayır';
        }

        if ($value instanceof \Carbon\Carbon) {
            return $value->format('d.m.Y H:i:s');
        }

        return (string) $value;
    }
}

<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class StressTestExporter
{
    private $results = [];
    private $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    public function addResult($testName, $metrics, $worksheetName = 'Sheet1')
    {
        if (!isset($this->results[$worksheetName])) {
            $this->results[$worksheetName] = [];
        }
        $this->results[$worksheetName][] = array_merge(['Test Name' => $testName], $metrics);
    }

    public function export($filename = 'stress_test_results.xlsx')
    {
        $isFirstSheet = true;

        foreach ($this->results as $worksheetName => $worksheetResults) {
            if ($isFirstSheet) {
                $sheet = $this->spreadsheet->getActiveSheet();
                $sheet->setTitle($worksheetName);
                $isFirstSheet = false;
            } else {
                $sheet = $this->spreadsheet->createSheet();
                $sheet->setTitle($worksheetName);
            }

            // Headers
            $headers = [
                'Test Name',
                'Toplam İstek Sayısı',
                'Aynı Anda Çalışan Kullanıcı Sayısı',
                'En Kısa Yanıt Süresi (ms)',
                'En Uzun Yanıt Süresi (ms)',
                'Ortalama Yanıt Süresi (ms)',
                'Başarı Oranı (%)',
                '90% Yanıt Süresi (ms)',
                '95% Yanıt Süresi (ms)',
                'Başarısız İstekler'
            ];

            foreach ($headers as $col => $header) {
                $columnLetter = Coordinate::stringFromColumnIndex($col + 1);
                $sheet->setCellValue($columnLetter . '1', $header);
            }

            // Data
            $row = 2;
            foreach ($worksheetResults as $result) {
                $col = 1;
                foreach ($result as $value) {
                    $columnLetter = Coordinate::stringFromColumnIndex($col);
                    $sheet->setCellValue($columnLetter . $row, $value);
                    $col++;
                }
                $row++;
            }

            // Auto-size columns
            foreach (range('A', $sheet->getHighestColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        // Klasör oluşturma ve dosya yolu ayarlama
        $dir = __DIR__ . '/../../public/TestSonuclari';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $fullPath = $dir . '/' . $filename;

        // Save file
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($fullPath);

        return $fullPath;
    }
}

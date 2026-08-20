<?php

require_once __DIR__ . '/ExportResults.php';
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

function guzzle_stress_test($method, $url, $options, $requests, $concurrency) {
    $client = new Client(['base_uri' => 'http://localhost', 'http_errors' => false, 'timeout' => 30]);
    $promises = [];
    $results = [];
    $startTimes = [];
    $endTimes = [];

    for ($i = 0; $i < $requests; $i++) {
        $startTimes[$i] = microtime(true);
        $promises[$i] = $client->{strtolower($method).'Async'}($url, $options)
            ->then(function ($response) use (&$endTimes, $i) {
                $endTimes[$i] = microtime(true);
                return $response;
            }, function ($e) use (&$endTimes, $i) {
                $endTimes[$i] = microtime(true);
                return null;
            });

        if (($i + 1) % $concurrency === 0) {
            Utils::settle($promises)->wait();
            $promises = [];
        }
    }

    if (!empty($promises)) {
        Utils::settle($promises)->wait();
    }

    foreach ($startTimes as $i => $startTime) {
        $duration = isset($endTimes[$i]) ? ($endTimes[$i] - $startTime) * 1000 : null;
        $results[] = [
            'success' => isset($endTimes[$i]),
            'duration' => $duration,
        ];
    }

    return $results;
}

function calculate_percentile($durations, $percentile) {
    sort($durations);
    $index = ceil(count($durations) * $percentile) - 1;
    return $durations[$index];
}

function run_test($exporter, $testName, $method, $url, $options, $userCount, $worksheetName) {
    $results = guzzle_stress_test(
        $method,
        $url,
        $options,
        $userCount,
        min(50, $userCount) // Concurrency sayısı userCount'tan büyük olmasın
    );

    $durations = array_filter(array_column($results, 'duration'));
    $successCount = array_sum(array_column($results, 'success'));
    $failCount = $userCount - $successCount;

    if (!empty($durations)) {
        $minDuration = min($durations);
        $maxDuration = max($durations);
        $avgDuration = array_sum($durations) / count($durations);
        $p90Duration = calculate_percentile($durations, 0.90);
        $p95Duration = calculate_percentile($durations, 0.95);
    } else {
        $minDuration = 0;
        $maxDuration = 0;
        $avgDuration = 0;
        $p90Duration = 0;
        $p95Duration = 0;
    }

    $successRate = ($successCount / $userCount) * 100;

    $exporter->addResult($testName, [
        'Toplam İstek Sayısı' => $userCount,
        'Aynı Anda Çalışan Kullanıcı Sayısı' => min(50, $userCount),
        'En Kısa Yanıt Süresi (ms)' => round($minDuration, 2),
        'En Uzun Yanıt Süresi (ms)' => round($maxDuration, 2),
        'Ortalama Yanıt Süresi (ms)' => round($avgDuration, 2),
        'Başarı Oranı (%)' => round($successRate, 2),
        '90% Yanıt Süresi (ms)' => round($p90Duration, 2),
        '95% Yanıt Süresi (ms)' => round($p95Duration, 2),
        'Başarısız İstekler' => $failCount
    ], $worksheetName);

    echo "\n{$testName} Sonuçları:";
    echo "\nToplam İstek: {$userCount}";
    echo "\nBaşarılı İstek: {$successCount}";
    echo "\nBaşarısız İstek: {$failCount}";
    echo "\nOrtalama Yanıt Süresi: " . round($avgDuration, 2) . "ms";
    echo "\n90% Yanıt Süresi: " . round($p90Duration, 2) . "ms";
    echo "\n95% Yanıt Süresi: " . round($p95Duration, 2) . "ms\n";
}

test('stress testleri', function () {
    $exporter = new StressTestExporter();

    // 1. Admin Giriş Testi (Daha gerçekçi sayılarla)
    $adminTestCases = [1, 10, 25];
    foreach ($adminTestCases as $userCount) {
        $testName = "{$userCount} Yönetici Login Testi";
        run_test(
            $exporter,
            $testName,
            'POST',
            '/login',
            [
                'form_params' => [
                    'email' => 'kadir@digitalambar.com',
                    'password' => 'Kadir2000'
                ]
            ],
            $userCount,
            'Admin Giriş'
        );
    }

    // 2. Bursiyer Giriş Yapma Testi
    $testCases = [50, 100, 500, 1000];
    foreach ($testCases as $userCount) {
        $testName = "{$userCount} Bursiyer Login Testi";
        run_test(
            $exporter,
            $testName,
            'POST',
            '/new-login-control',
            [
                'form_params' => [
                    'email' => 'test@example.com',
                    'password' => 'test123'
                ]
            ],
            $userCount,
            'Bursiyer Giriş'
        );
    }

    // 3. Bursiyer Başvurusu Testi
    foreach ($testCases as $userCount) {
        $testName = "{$userCount} Bursiyer Başvuru Testi";
        run_test(
            $exporter,
            $testName,
            'POST',
            '/basvuru/store',
            [
                'form_params' => [
                    'name' => 'Test User',
                    'surname' => 'Test Surname',
                    'tc_no' => '12345678901',
                    'email' => 'test@example.com',
                    'tel_no' => '+905551234567',
                    'aday_turu' => 'Dernek',
                    'educationType' => 'lisans',
                    'university_city' => 'İstanbul',
                    'current_university' => 'İstanbul Üniversitesi',
                    'university_faculty' => 'Mühendislik Fakültesi',
                    'department' => 'Bilgisayar Mühendisliği',
                    'university_type' => 'Devlet',
                    'university_class' => '3.Sınıf',
                    'student_number' => '12345678',
                    'agno_type' => '4\'lük',
                    'agno' => '3.50'
                ]
            ],
            $userCount,
            'Bursiyer Başvuru'
        );
    }

    // 4. Kayıt Yenileme Başvurusu Testi
    foreach ($testCases as $userCount) {
        $testName = "{$userCount} Bursiyer Kayıt Yenileme Testi";
        run_test(
            $exporter,
            $testName,
            'POST',
            '/kayit-yenileme/store',
            [
                'form_params' => [
                    'name' => 'Test User',
                    'surname' => 'Test Surname',
                    'tc_no' => '12345678901',
                    'email' => 'test@example.com',
                    'tel_no' => '+905551234567',
                    'aday_turu' => 'Dernek',
                    'educationType' => 'lisans',
                    'university_city' => 'İstanbul',
                    'current_university' => 'İstanbul Üniversitesi',
                    'university_faculty' => 'Mühendislik Fakültesi',
                    'department' => 'Bilgisayar Mühendisliği',
                    'university_type' => 'Devlet',
                    'university_class' => '3.Sınıf',
                    'student_number' => '12345678',
                    'agno_type' => '4\'lük',
                    'agno' => '3.50',
                    'housing_type' => 'Ev',
                    'housing_fee' => '2500',
                    'living_with_count' => '3',
                    'residing_city' => 'İstanbul',
                    'residing_district' => 'Kadıköy',
                    'address_detail' => 'Test Adres'
                ]
            ],
            $userCount,
            'Kayıt Yenileme'
        );
    }

    // Test sonuçlarını Excel'e aktar
    $filename = 'Stress_Test_Sonuclari_' . date('Y-m-d_H-i-s') . '.xlsx';
    $filePath = $exporter->export($filename);
    echo "\nTest sonuçları {$filePath} dosyasına kaydedildi.\n";
});

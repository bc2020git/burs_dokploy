<?php

try {
    // config:cache komutunu çalıştır
    $outputConfig = shell_exec('composer require maatwebsite/excel');
    echo "Config cache has been refreshed: " . $outputConfig . "\n";


    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

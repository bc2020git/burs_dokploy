<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MessageTemplate;

$templates = MessageTemplate::where('title', 'LIKE', 'Aday - Burs Red%')->get();
echo "Found " . count($templates) . " templates\n";
foreach($templates as $t) {
    echo "ID: {$t->id} | Title: [" . $t->title . "] | Len: " . strlen($t->title) . " | Slug: " . $t->slug . "\n";
}

$search = "Aday - Burs Red - Eksik Belge";
echo "\nSearching for: [" . $search . "]\n";
$found = MessageTemplate::where('title', $search)->first();
if ($found) {
    echo "Found! ID: " . $found->id . "\n";
} else {
    echo "NOT FOUND!\n";
}

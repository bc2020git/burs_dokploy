<?php
$files = glob('database/seeders/*Seeder.php');
$classes = [];
foreach($files as $file) {
    $basename = basename($file, '.php');
    if ($basename !== 'DatabaseSeeder') {
        $classes[] = $basename;
    }
}
$callString = implode("::class,\n            ", $classes);

$content = "<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \$this->call([
            {$callString}::class
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
";
file_put_contents('database/seeders/DatabaseSeeder.php', $content);
echo "DatabaseSeeder.php generated.\n";

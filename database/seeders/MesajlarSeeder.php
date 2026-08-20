<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesajlarSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mesajlar')->insert(array (
  0 => 
  array (
    'id' => 3,
    'title' => 'Baslik',
    'text' => 'Baslik2 icerik',
    'created_at' => '2024-10-27 17:29:41',
    'updated_at' => '2024-10-27 17:34:33',
  ),
  1 => 
  array (
    'id' => 4,
    'title' => 'Yeni Bildirim',
    'text' => 'Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir. Bu bir bildirim icerigidir.',
    'created_at' => '2024-10-27 19:16:35',
    'updated_at' => '2024-10-27 19:16:35',
  ),
  2 => 
  array (
    'id' => 5,
    'title' => 'Lorem ipsum bildirim mesaj ornegi',
    'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at eleifend nibh. Sed vestibulum faucibus arcu, et aliquet elit rhoncus eu. Etiam sem quam, convallis eu felis at, auctor egestas orci. Sed enim ligula, venenatis eu suscipit at, sollicitudin in ipsum. Nulla non dictum nulla. Duis hendrerit euismod sapien id fringilla. Sed dapibus pulvinar ex. Proin ac rhoncus odio. Mauris a tincidunt sem, et varius leo. Nulla odio neque, sagittis quis molestie sit amet, dignissim iaculis tellus.',
    'created_at' => '2024-10-28 11:53:36',
    'updated_at' => '2024-10-28 11:53:36',
  ),
));
    }
}
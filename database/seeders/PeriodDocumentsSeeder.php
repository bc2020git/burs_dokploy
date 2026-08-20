<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodDocumentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('period_documents')->insert(array (
  0 => 
  array (
    'id' => 666,
    'period_id' => 65,
    'school_type' => 'lise',
    'documents' => '["doc_ogrenciBelgesi","doc_fotograf","doc_adlisicilkaydi","doc_nufuskayitornegi","doc_annegelirbelgesi","doc_babagelirbelgesi","doc_kimlik","doc_bankahesap","doc_ikametgah","doc_Karne","doc_Diger","doc_ogrenciBelgesi","doc_fotograf","doc_adlisicilkaydi","doc_nufuskayitornegi","doc_annegelirbelgesi","doc_babagelirbelgesi","doc_kimlik","doc_bankahesap","doc_ikametgah","doc_Karne","doc_Diger"]',
    'created_at' => '2025-09-12 20:07:39',
    'updated_at' => '2025-09-12 20:07:39',
  ),
  1 => 
  array (
    'id' => 667,
    'period_id' => 65,
    'school_type' => 'lisans',
    'documents' => '["doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_nufuskayitornegi","doc_annegelirbelgesi","doc_babagelirbelgesi","doc_kimlik","doc_bankahesap","doc_ikametgah","doc_Diger","doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_nufuskayitornegi","doc_annegelirbelgesi","doc_babagelirbelgesi","doc_kimlik","doc_bankahesap","doc_ikametgah","doc_Diger"]',
    'created_at' => '2025-09-12 20:07:39',
    'updated_at' => '2025-09-12 20:07:39',
  ),
  2 => 
  array (
    'id' => 668,
    'period_id' => 65,
    'school_type' => 'yukseklisans',
    'documents' => '["doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_nufuskayitornegi","doc_annegelirbelgesi","doc_babagelirbelgesi","doc_kimlik","doc_bankahesap","doc_ikametgah","doc_Diger","ighQjUalaMaC","GwE6ihPjXCa0","NHax7LHeC7is","qPATCAf9VzUI","doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_nufuskayitornegi","doc_annegelirbelgesi","doc_babagelirbelgesi","doc_kimlik","doc_bankahesap","doc_ikametgah","doc_Diger","ighQjUalaMaC","GwE6ihPjXCa0","NHax7LHeC7is","qPATCAf9VzUI"]',
    'created_at' => '2025-09-12 20:07:39',
    'updated_at' => '2025-09-12 20:07:39',
  ),
  3 => 
  array (
    'id' => 673,
    'period_id' => 74,
    'school_type' => 'lisans',
    'documents' => '["doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi"]',
    'created_at' => '2025-09-26 14:01:08',
    'updated_at' => '2025-09-26 14:01:08',
  ),
  4 => 
  array (
    'id' => 674,
    'period_id' => 74,
    'school_type' => 'yukseklisans',
    'documents' => '["doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi"]',
    'created_at' => '2025-09-26 14:01:08',
    'updated_at' => '2025-09-26 14:01:08',
  ),
  5 => 
  array (
    'id' => 675,
    'period_id' => 73,
    'school_type' => 'lisans',
    'documents' => '["doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi"]',
    'created_at' => '2025-10-03 02:40:48',
    'updated_at' => '2025-10-03 02:40:48',
  ),
  6 => 
  array (
    'id' => 676,
    'period_id' => 73,
    'school_type' => 'yukseklisans',
    'documents' => '["doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi","doc_ogrenciBelgesi","doc_fotograf","doc_transkript","doc_adlisicilkaydi"]',
    'created_at' => '2025-10-03 02:40:48',
    'updated_at' => '2025-10-03 02:40:48',
  ),
  7 => 
  array (
    'id' => 677,
    'period_id' => 75,
    'school_type' => 'ilkokul',
    'documents' => '["doc_ogrenciBelgesi","doc_Karne","doc_Diger"]',
    'created_at' => '2026-01-20 13:47:54',
    'updated_at' => '2026-01-20 13:47:54',
  ),
  8 => 
  array (
    'id' => 678,
    'period_id' => 75,
    'school_type' => 'ortaokul',
    'documents' => '["doc_ogrenciBelgesi","doc_Karne","doc_Diger"]',
    'created_at' => '2026-01-20 13:47:54',
    'updated_at' => '2026-01-20 13:47:54',
  ),
  9 => 
  array (
    'id' => 679,
    'period_id' => 75,
    'school_type' => 'lise',
    'documents' => '["doc_ogrenciBelgesi","doc_Karne","doc_Diger"]',
    'created_at' => '2026-01-20 13:47:54',
    'updated_at' => '2026-01-20 13:47:54',
  ),
));
    }
}
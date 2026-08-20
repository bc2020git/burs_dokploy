<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('burs_taksitleri')) {
            Schema::create('burs_taksitleri', function (Blueprint $table): void {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_unicode_ci';
                $table->bigIncrements('id');
                $table->unsignedBigInteger('burs_tipi_id');
                $table->string('donem', 255);
                $table->decimal('burs_tutari', 12, 2);
                $table->unsignedInteger('taksit_sayisi');
                $table->date('baslangic_tarihi');
                $table->timestamp('created_at', 0)->nullable();
                $table->timestamp('updated_at', 0)->nullable();
                $table->unique(['burs_tipi_id', 'donem'], 'burs_taksitleri_burs_tipi_id_donem_unique');
                $table->foreign('burs_tipi_id', 'burs_taksitleri_burs_tipi_id_foreign')->references('id')->on('tanim_burs_tipis')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('burs_taksitleri');
    }
};

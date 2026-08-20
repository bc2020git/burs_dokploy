<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataImport extends Model
{
    use HasFactory;
    protected $table = 'data_import';

    protected $guarded = [];

    public function logs()
    {
        return $this->hasMany(DataImportLog::class, 'data_import_id');
    }

    public function getErrorLogs()
    {
        return $this->logs()->where('status', 'Hata')->get();
    }

    public function getSuccessLogs()
    {
        return $this->logs()->where('status', 'Başarılı')->get();
    }
}

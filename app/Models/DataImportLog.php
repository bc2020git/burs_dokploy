<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataImportLog extends Model
{
    use HasFactory;

    protected $table = 'data_import_logs';

    protected $fillable = [
        'data_import_id',
        'status',
        'data',
        'description',
        'row_number'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function dataImport()
    {
        return $this->belongsTo(DataImport::class, 'data_import_id');
    }
}

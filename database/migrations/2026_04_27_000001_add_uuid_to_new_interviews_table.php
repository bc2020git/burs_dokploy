<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('new_interviews', 'uuid')) {
            Schema::table('new_interviews', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->after('id');
            });
        }

        // Fill missing uuid values for existing records.
        DB::table('new_interviews')
            ->whereNull('uuid')
            ->orWhere('uuid', '')
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('new_interviews')
                        ->where('id', $row->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                }
            });

        // Add unique index (if not already present).
        $dbName = DB::getDatabaseName();
        $indexExists = DB::table('information_schema.statistics')
            ->where('table_schema', $dbName)
            ->where('table_name', 'new_interviews')
            ->where('index_name', 'new_interviews_uuid_unique')
            ->exists();

        if (! $indexExists) {
            Schema::table('new_interviews', function (Blueprint $table) {
                $table->unique('uuid', 'new_interviews_uuid_unique');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('new_interviews', 'uuid')) {
            Schema::table('new_interviews', function (Blueprint $table) {
                $table->dropUnique('new_interviews_uuid_unique');
                $table->dropColumn('uuid');
            });
        }
    }
};


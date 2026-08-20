<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('otp_settings')) {
            return;
        }

        if (! Schema::hasColumn('otp_settings', 'admin_otp_status')) {
            Schema::table('otp_settings', function (Blueprint $table) {
                $table->boolean('admin_otp_status')->default(false)->after('portal_otp_status');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('otp_settings')) {
            return;
        }

        if (Schema::hasColumn('otp_settings', 'admin_otp_status')) {
            Schema::table('otp_settings', function (Blueprint $table) {
                $table->dropColumn('admin_otp_status');
            });
        }
    }
};


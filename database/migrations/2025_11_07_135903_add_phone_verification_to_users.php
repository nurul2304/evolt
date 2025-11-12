<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // tambahkan hanya kolom yang belum ada
            if (!Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            }

            if (!Schema::hasColumn('users', 'otp_hash')) {
                $table->string('otp_hash')->nullable()->after('remember_token');
            }

            // ❌ HAPUS BARIS INI karena sudah ada di tabel users
            // $table->timestamp('otp_expires_at')->nullable()->after('otp_hash');

            if (!Schema::hasColumn('users', 'otp_attempts')) {
                $table->integer('otp_attempts')->default(0)->after('remember_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $drop = [];
            foreach (['phone_verified_at', 'otp_hash', 'otp_attempts'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $drop[] = $column;
                }
            }

            if ($drop) {
                $table->dropColumn($drop);
            }
        });
    }
};

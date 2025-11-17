<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // ✅ tambahkan ini
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔹 Buat akun admin default
        User::updateOrCreate(
            ['email' => 'admin@evolt.com'],
            [
                'username' => 'admin',
                'nomor_plat' => 'ADMIN001',
                'nomor_telepon' => '081234567890',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}

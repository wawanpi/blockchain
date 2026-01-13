<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role; // <-- PENTING: Import Model Role dari Spatie
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Reset Cache Permission (Penting untuk menghindari error cache)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. BUAT ROLE (Ini langkah yang hilang di error Anda)
        // Kita gunakan firstOrCreate agar tidak error jika data sudah ada
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $rolePelanggan = Role::firstOrCreate(['name' => 'pelanggan']);

        // 3. Buat User Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );
        // Berikan role admin ke user ini
        $admin->assignRole($roleAdmin);

        // 4. Buat User Pelanggan (Contoh)
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        // Berikan role pelanggan ke user ini
        $user->assignRole($rolePelanggan);
    }
}
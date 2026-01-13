<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; // <-- Impor model User

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Role
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'user']);

        // (Opsional) Anda bisa membuat permissions di sini jika perlu
        // Permission::create(['name' => 'edit articles']);

        // (Opsional) Dan menetapkan permission ke role
        // $roleAdmin->givePermissionTo('edit articles');

        // PENTING: Menetapkan role 'admin' ke user pertama (ID=1)
        // Pastikan user dengan ID 1 sudah ada sebelum menjalankan seeder ini
        // Jika belum ada, Anda bisa membuatnya dulu via Tinker atau seeder lain
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole($roleAdmin);
            $this->command->info('User ID 1 assigned as admin.');
        } else {
            // Atau buat user admin baru jika user ID 1 tidak ada
            $admin = User::factory()->create([
                 'name' => 'Admin User',
                 'email' => 'admin@example.com', // Ganti dengan email admin Anda
             ]);
            $admin->assignRole($roleAdmin);
             $this->command->info('Admin user created and assigned role.');
        }

        $this->command->info('Roles created: admin, user');
    }
}
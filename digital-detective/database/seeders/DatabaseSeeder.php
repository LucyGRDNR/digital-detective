<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// No need to directly use Spatie\Permission\Models\Role here anymore for role creation
// No need for Spatie\Permission\PermissionRegistrar::class here, as RolesAndPermissionsSeeder handles it

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);


        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('adminskeHeslo'),
            ]
        );

        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin'); 
            $this->command->info('Admin user created/found and assigned admin role.');
        } else {
            $this->command->info('Admin user already exists and has admin role.');
        }

    }
}
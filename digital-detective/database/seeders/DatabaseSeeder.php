<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            StoriesTableSeeder::class,
            ChaptersTableSeeder::class,
            QuestionsTableSeeder::class,
            OptionsTableSeeder::class,
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
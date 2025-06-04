<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
        ]);

        Role::create(['name' => 'admin']);

        $admin = User::create([
            'name' => "admin",
            'email' => "admin@admin.com",
            'password' => Hash::make("adminskeHeslo"),
        ]);
        $admin->assgnRole('admin');

        $this->call([
            StoriesTableSeeder::class,
            ChaptersTableSeeder::class,
            QuestionsTableSeeder::class,
            HintsTableSeeder::class,
            OptionsTableSeeder::class,
        ]);
    }
}

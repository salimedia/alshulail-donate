<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in proper order (respecting foreign key dependencies)
        $this->call([
            CategorySeeder::class,
            SettingSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            ProjectSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Admin login: admin@alshulail-donate.org');
        $this->command->info('🔑 Password: password');
    }
}

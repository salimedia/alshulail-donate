<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = \App\Models\User::create([
            'name' => 'مدير المنصة',
            'email' => 'admin@alshulail-donate.org',
            'password' => bcrypt('password'),
            'phone' => '+966501234567',
            'country' => 'Saudi Arabia',
            'city' => 'Riyadh',
            'preferred_language' => 'ar',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Demo Donor Users
        $donors = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmad@example.com',
                'password' => bcrypt('password'),
                'phone' => '+966501111111',
                'country' => 'Saudi Arabia',
                'city' => 'Jeddah',
                'preferred_language' => 'ar',
                'total_donated' => 5000,
                'donations_count' => 3,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'فاطمة عبدالله',
                'email' => 'fatima@example.com',
                'password' => bcrypt('password'),
                'phone' => '+966502222222',
                'country' => 'Saudi Arabia',
                'city' => 'Dammam',
                'preferred_language' => 'ar',
                'total_donated' => 3000,
                'donations_count' => 2,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'password' => bcrypt('password'),
                'phone' => '+1234567890',
                'country' => 'United States',
                'city' => 'New York',
                'preferred_language' => 'en',
                'total_donated' => 2000,
                'donations_count' => 1,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($donors as $donor) {
            \App\Models\User::create($donor);
        }
    }
}

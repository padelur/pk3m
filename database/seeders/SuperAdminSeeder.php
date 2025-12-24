<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@makmurmandirimedika.com'],
            [
            'name' => 'Super Admin',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
                'is_active' => true,
            'email_verified_at' => now(),
            ]
        );

        // Create sample Admin
        User::updateOrCreate(
            ['email' => 'admin@makmurmandirimedika.com'],
            [
            'name' => 'Admin',
            'password' => Hash::make('password123'),
            'role' => 'admin',
                'is_active' => true,
            'email_verified_at' => now(),
            ]
        );
    }
}

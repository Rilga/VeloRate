<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator System',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'division' => 'IT Department',
            'position' => 'System Administrator',
            'status' => 'active',
        ]);

        // 2. Akun Manager
        User::create([
            'name' => 'Manager HR',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('manager12345'),
            'role' => 'manager',
            'division' => 'Human Resources',
            'position' => 'HR Manager',
            'status' => 'active',
        ]);

        // 3. Akun User (Karyawan)
        User::create([
            'name' => 'Karwayan A',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user12345'),
            'role' => 'user',
            'division' => 'Information Systems',
            'position' => 'Backend Developer', 
            'status' => 'active',
        ]);
    }
}
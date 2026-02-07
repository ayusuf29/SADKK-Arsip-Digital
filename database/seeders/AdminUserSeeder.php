<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@banksulteng.co.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Operator User
        User::updateOrCreate(
            ['username' => 'operator'],
            [
                'name' => 'Operator',
                'email' => 'operator@banksulteng.co.id',
                'password' => Hash::make('password'),
                'role' => 'operator',
            ]
        );
    }
}

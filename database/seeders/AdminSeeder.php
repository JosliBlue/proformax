<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'user_name' => 'Administrador',
            'user_email' => 'admin@proformax.com',
            'user_password' => Hash::make('admin123'),
            'user_rol' => 'admin'
        ]);
    }
}

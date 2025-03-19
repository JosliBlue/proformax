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
            'nombre' => 'Administrador',
            'email' => 'admin@proformax.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin'
        ]);
    }
}

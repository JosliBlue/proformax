<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'user_name' => 'Administrador',
                'user_email' => 'admin@proformax.com',
                'user_password' => Hash::make('admin123'),
                'user_rol' => 'admin'
            ],
            [
                'user_name' => 'Usuario',
                'user_email' => 'user@proformax.com',
                'user_password' => Hash::make('user123'),
                'user_rol' => 'user'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

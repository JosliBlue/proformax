<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'user_name' => 'Administrador',
                'user_email' => 'admin@proformax.com',
                'user_password' => Hash::make('admin123'),
                'user_rol' => 'admin',
                'company_id' => '1',
                'is_superuser' => true, // El primer usuario es superusuario
            ],
            [
                'user_name' => 'Usuario',
                'user_email' => 'user@proformax.com',
                'user_password' => Hash::make('user123'),
                'user_rol' => 'user',
                'company_id' => '1',
                'is_superuser' => false,
            ],
            [
                'user_name' => 'Nulito',
                'user_email' => 'nulo@proformax.com',
                'user_password' => Hash::make('nulo123'),
                'user_rol' => 'user',
                'company_id' => null,
                'is_superuser' => false,
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

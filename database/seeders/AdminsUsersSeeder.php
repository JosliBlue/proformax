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
            // Giga compañia (empresa 1)
            [
                'user_name' => 'Jose Muyulema',
                'user_email' => 'admin@proformax.com',
                'user_password' => Hash::make('admin123'),
                'user_rol' => 'admin',
                'company_id' => 1,
                'is_superuser' => true,
                'user_status' => true
            ],
            [
                'user_name' => 'Lucas Méndez',
                'user_email' => 'lucas.mendez@proformax.com',
                'user_password' => Hash::make('lucas2025'),
                'user_rol' => 'admin',
                'company_id' => 1,
                'is_superuser' => false,
                'user_status' => true
            ],
            [
                'user_name' => 'Valentina Ruiz',
                'user_email' => 'valentina.ruiz@proformax.com',
                'user_password' => Hash::make('valen2025'),
                'user_rol' => 'user',
                'company_id' => 1,
                'is_superuser' => false,
                'user_status' => true
            ],
            // ArseAccesorios (empresa 2)
            [
                'user_name' => 'Aracelly Guangasi',
                'user_email' => 'aracelly@arse.com',
                'user_password' => Hash::make('martin2025'),
                'user_rol' => 'admin',
                'company_id' => 2,
                'is_superuser' => true,
                'user_status' => true
            ],
            [
                'user_name' => 'Camila Paredes',
                'user_email' => 'camila.paredes@arse.com',
                'user_password' => Hash::make('camila2025'),
                'user_rol' => 'user',
                'company_id' => 2,
                'is_superuser' => false,
                'user_status' => true
            ],
            [
                'user_name' => 'Jorge Salinas',
                'user_email' => 'jorge.salinas@arse.com',
                'user_password' => Hash::make('jorge2025'),
                'user_rol' => 'user',
                'company_id' => 2,
                'is_superuser' => false,
                'user_status' => true
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

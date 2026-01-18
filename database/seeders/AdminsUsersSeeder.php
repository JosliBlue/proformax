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
            // VM Metalmecanica  (empresa 1)
            [
                'user_name' => 'Victor Muyulema',
                'user_email' => 'victor.muyulema@vm.com',
                'user_password' => Hash::make('cambiar123'),
                'user_rol' => 'gerente',
                'company_id' => 1,
                'user_status' => true
            ],
            [
                'user_name' => 'Jose Muyulema',
                'user_email' => 'jose.muyulema@vm.com',
                'user_password' => Hash::make('cambiar123'),
                'user_rol' => 'vendedor',
                'company_id' => 1,
                'user_status' => true
            ],
            // Arte Parquet (empresa 2)
            [
                'user_name' => 'Jose Guangasi',
                'user_email' => 'jose.guangasi@arte.com',
                'user_password' => Hash::make('cambiar123'),
                'user_rol' => 'gerente',
                'company_id' => 2,
                'user_status' => true
            ],
            [
                'user_name' => 'Aracelly Guangasi',
                'user_email' => 'aracelly.guangasi@arte.com',
                'user_password' => Hash::make('cambiar123'),
                'user_rol' => 'vendedor',
                'company_id' => 2,
                'user_status' => true
            ],
            // EMPRESA DEMO (empresa 3) 
            [
                'user_name' => 'Gerente DEMO',
                'user_email' => 'gerente@demo.com',
                'user_password' => Hash::make('demo123'),
                'user_rol' => 'gerente',
                'company_id' => 3,
                'user_status' => true
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

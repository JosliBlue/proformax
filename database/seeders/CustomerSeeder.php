<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'customer_name' => 'Juan',
                'customer_lastname' => 'Pérez',
                'customer_phone' => '999888777',
                'customer_email' => 'juan@example.com'
            ],
            [
                'customer_name' => 'María',
                'customer_lastname' => 'Gómez',
                'customer_phone' => '999888666',
                'customer_email' => 'maria@example.com'
            ],
            [
                'customer_name' => 'Carlos',
                'customer_lastname' => 'López',
                'customer_phone' => '999888555',
                'customer_email' => 'carlos@example.com'
            ],
            [
                'customer_name' => 'Ana',
                'customer_lastname' => 'Martínez',
                'customer_phone' => '999888444',
                'customer_email' => 'ana@example.com'
            ],
            [
                'customer_name' => 'Luis',
                'customer_lastname' => 'Rodríguez',
                'customer_phone' => '999888333',
                'customer_email' => 'luis@example.com'
            ],
            [
                'customer_name' => 'Sofía',
                'customer_lastname' => 'Hernández',
                'customer_phone' => '999888222',
                'customer_email' => 'sofia@example.com'
            ],
            [
                'customer_name' => 'Pedro',
                'customer_lastname' => 'Díaz',
                'customer_phone' => '999888111',
                'customer_email' => 'pedro@example.com'
            ],
            [
                'customer_name' => 'Laura',
                'customer_lastname' => 'García',
                'customer_phone' => '999888000',
                'customer_email' => 'laura@example.com'
            ],
            [
                'customer_name' => 'Miguel',
                'customer_lastname' => 'Fernández',
                'customer_phone' => '999777666',
                'customer_email' => 'miguel@example.com'
            ],
            [
                'customer_name' => 'Elena',
                'customer_lastname' => 'Sánchez',
                'customer_phone' => '999777555',
                'customer_email' => 'elena@example.com'
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}

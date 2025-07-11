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
                'customer_name' => 'Andrea',
                'customer_lastname' => 'García',
                'customer_cedula' => '1234567890',
                'customer_phone' => '0999111222',
                'customer_email' => 'andrea.garcia@cliente.com',
                'company_id' => 1,
                'customer_status' => true
            ],
            [
                'customer_name' => 'Pedro',
                'customer_lastname' => 'López',
                'customer_cedula' => null,
                'customer_phone' => '0999111333',
                'customer_email' => 'pedro.lopez@cliente.com',
                'company_id' => 1,
                'customer_status' => true
            ],
            [
                'customer_name' => 'Marina',
                'customer_lastname' => 'Soto',
                'customer_cedula' => '1345678901',
                'customer_phone' => '0999111444',
                'customer_email' => 'marina.soto@cliente.com',
                'company_id' => 1,
                'customer_status' => true
            ],
            [
                'customer_name' => 'Iván',
                'customer_lastname' => 'Vega',
                'customer_cedula' => null,
                'customer_phone' => '0999111555',
                'customer_email' => 'ivan.vega@cliente.com',
                'company_id' => 1,
                'customer_status' => true
            ],
            [
                'customer_name' => 'Rocío',
                'customer_lastname' => 'Navarro',
                'customer_cedula' => '1567890123',
                'customer_phone' => '0888222111',
                'customer_email' => 'rocio.navarro@cliente.com',
                'company_id' => 2,
                'customer_status' => true
            ],
            [
                'customer_name' => 'Esteban',
                'customer_lastname' => 'Campos',
                'customer_cedula' => null,
                'customer_phone' => '0888222333',
                'customer_email' => 'esteban.campos@cliente.com',
                'company_id' => 2,
                'customer_status' => true
            ],
            [
                'customer_name' => 'Paula',
                'customer_lastname' => 'Mora',
                'customer_cedula' => '1789012345',
                'customer_phone' => '0888222444',
                'customer_email' => 'paula.mora@cliente.com',
                'company_id' => 2,
                'customer_status' => true
            ],
            [
                'customer_name' => 'Felipe',
                'customer_lastname' => 'Ríos',
                'customer_cedula' => null,
                'customer_phone' => '0888222555',
                'customer_email' => 'felipe.rios@cliente.com',
                'company_id' => 2,
                'customer_status' => true
            ]
        ];
        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}

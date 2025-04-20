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
                'customer_email' => 'juan@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'María',
                'customer_lastname' => 'Gómez',
                'customer_phone' => '999888666',
                'customer_email' => 'maria@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Carlos',
                'customer_lastname' => 'López',
                'customer_phone' => '999888555',
                'customer_email' => 'carlos@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Ana',
                'customer_lastname' => 'Martínez',
                'customer_phone' => '999888444',
                'customer_email' => 'ana@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Luis',
                'customer_lastname' => 'Rodríguez',
                'customer_phone' => '999888333',
                'customer_email' => 'luis@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Sofía',
                'customer_lastname' => 'Hernández',
                'customer_phone' => '999888222',
                'customer_email' => 'sofia@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Pedro',
                'customer_lastname' => 'Díaz',
                'customer_phone' => '999888111',
                'customer_email' => 'pedro@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Laura',
                'customer_lastname' => 'García',
                'customer_phone' => '999888000',
                'customer_email' => 'laura@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Miguel',
                'customer_lastname' => 'Fernández',
                'customer_phone' => '999777666',
                'customer_email' => 'miguel@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Elena',
                'customer_lastname' => 'Sánchez',
                'customer_phone' => '999777555',
                'customer_email' => 'elena@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Diego',
                'customer_lastname' => 'Ramírez',
                'customer_phone' => '999777444',
                'customer_email' => 'diego@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Valeria',
                'customer_lastname' => 'Torres',
                'customer_phone' => '999777333',
                'customer_email' => 'valeria@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Javier',
                'customer_lastname' => 'Castro',
                'customer_phone' => '999777222',
                'customer_email' => 'javier@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Camila',
                'customer_lastname' => 'Ortiz',
                'customer_phone' => '999777111',
                'customer_email' => 'camila@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Andrés',
                'customer_lastname' => 'Morales',
                'customer_phone' => '999777000',
                'customer_email' => 'andres@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Paula',
                'customer_lastname' => 'Vargas',
                'customer_phone' => '999666999',
                'customer_email' => 'paula@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Fernando',
                'customer_lastname' => 'Rojas',
                'customer_phone' => '999666888',
                'customer_email' => 'fernando@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Isabel',
                'customer_lastname' => 'Mendoza',
                'customer_phone' => '999666777',
                'customer_email' => 'isabel@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Ricardo',
                'customer_lastname' => 'Guerrero',
                'customer_phone' => '999666666',
                'customer_email' => 'ricardo@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Natalia',
                'customer_lastname' => 'Cruz',
                'customer_phone' => '999666555',
                'customer_email' => 'natalia@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Hugo',
                'customer_lastname' => 'Paredes',
                'customer_phone' => '999666444',
                'customer_email' => 'hugo@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Claudia',
                'customer_lastname' => 'Peña',
                'customer_phone' => '999666333',
                'customer_email' => 'claudia@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Sebastián',
                'customer_lastname' => 'Navarro',
                'customer_phone' => '999666222',
                'customer_email' => 'sebastian@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Lucía',
                'customer_lastname' => 'Campos',
                'customer_phone' => '999666111',
                'customer_email' => 'lucia@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Tomás',
                'customer_lastname' => 'Silva',
                'customer_phone' => '999666000',
                'customer_email' => 'tomas@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Gabriela',
                'customer_lastname' => 'Reyes',
                'customer_phone' => '999555999',
                'customer_email' => 'gabriela@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Manuel',
                'customer_lastname' => 'Flores',
                'customer_phone' => '999555888',
                'customer_email' => 'manuel@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Carolina',
                'customer_lastname' => 'Salazar',
                'customer_phone' => '999555777',
                'customer_email' => 'carolina@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Francisco',
                'customer_lastname' => 'Mora',
                'customer_phone' => '999555666',
                'customer_email' => 'francisco@example.com',
                'company_id' => '1',
            ],
            [
                'customer_name' => 'Daniela',
                'customer_lastname' => 'Esquivel',
                'customer_phone' => '999555555',
                'customer_email' => 'daniela@example.com',
                'company_id' => '1',
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}

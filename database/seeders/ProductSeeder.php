<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Productos físicos
            [
                'product_name' => 'Mouse inalámbrico',
                'product_type' => 'producto',
                'product_price' => 25.50,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Laptop HP',
                'product_type' => 'producto',
                'product_price' => 1200.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Teclado mecánico',
                'product_type' => 'producto',
                'product_price' => 75.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Monitor 24"',
                'product_type' => 'producto',
                'product_price' => 180.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Impresora láser',
                'product_type' => 'producto',
                'product_price' => 200.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Disco SSD 500GB',
                'product_type' => 'producto',
                'product_price' => 60.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Memoria RAM 8GB',
                'product_type' => 'producto',
                'product_price' => 35.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Webcam HD',
                'product_type' => 'producto',
                'product_price' => 45.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Router WiFi',
                'product_type' => 'producto',
                'product_price' => 80.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Altavoces Bluetooth',
                'product_type' => 'producto',
                'product_price' => 55.00,
                'company_id' => '1',
            ],

            // Servicios
            [
                'product_name' => 'Mantenimiento mensual',
                'product_type' => 'servicio',
                'product_price' => 150.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Instalación de software',
                'product_type' => 'servicio',
                'product_price' => 50.00,
                'company_id' => '1',
            ],
            [
                'product_name' => 'Configuración de red',
                'product_type' => 'servicio',
                'product_price' => 80.00,
                'company_id' => '1',
            ]

        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

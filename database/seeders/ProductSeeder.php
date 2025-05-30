<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Productos y servicios Giga compañia (empresa 1)
            [
                'product_name' => 'Laptop Ultra X',
                'product_type' => 'producto',
                'product_price' => 1450.00,
                'company_id' => 1,
                'product_status' => true
            ],
            [
                'product_name' => 'Monitor 27" 4K',
                'product_type' => 'producto',
                'product_price' => 320.00,
                'company_id' => 1,
                'product_status' => true
            ],
            [
                'product_name' => 'Teclado RGB Pro',
                'product_type' => 'producto',
                'product_price' => 95.00,
                'company_id' => 1,
                'product_status' => true
            ],
            [
                'product_name' => 'Soporte técnico remoto',
                'product_type' => 'servicio',
                'product_price' => 60.00,
                'company_id' => 1,
                'product_status' => true
            ],
            [
                'product_name' => 'Instalación de redes',
                'product_type' => 'servicio',
                'product_price' => 180.00,
                'company_id' => 1,
                'product_status' => true
            ],
            // Productos y servicios ArseAccesorios (empresa 2)
            [
                'product_name' => 'Cemento Portland 50kg',
                'product_type' => 'producto',
                'product_price' => 12.50,
                'company_id' => 2,
                'product_status' => true
            ],
            [
                'product_name' => 'Ladrillo hueco',
                'product_type' => 'producto',
                'product_price' => 0.45,
                'company_id' => 2,
                'product_status' => true
            ],
            [
                'product_name' => 'Arena fina m3',
                'product_type' => 'producto',
                'product_price' => 18.00,
                'company_id' => 2,
                'product_status' => true
            ],
            [
                'product_name' => 'Mano de obra albañilería',
                'product_type' => 'servicio',
                'product_price' => 250.00,
                'company_id' => 2,
                'product_status' => true
            ],
            [
                'product_name' => 'Supervisión de obra',
                'product_type' => 'servicio',
                'product_price' => 400.00,
                'company_id' => 2,
                'product_status' => true
            ]
        ];
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

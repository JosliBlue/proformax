<?php

namespace Database\Seeders;

use App\Models\Paper;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PaperSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de recursos existentes
        $adminId = 1; // ID del usuario admin (creado en AdminsUsersSeeder)
        $customerIds = range(1, 30); // IDs de clientes (creados en CustomerSeeder)
        $productIds = Product::where('company_id', 1)->pluck('id')->toArray();

        $papers = [
            [
                'user_id' => $adminId,
                'customer_id' => 1, // Juan Pérez
                'company_id' => 1,
                'paper_total_price' => 325.50,
                'paper_days' => '7 días',
                'paper_status' => true,
                'created_at' => Carbon::now()->subDays(3),
                'products' => [
                    [
                        'product_id' => 1, // Mouse inalámbrico
                        'quantity' => 2,
                        'unit_price' => 25.50,
                        'subtotal' => 51.00
                    ],
                    [
                        'product_id' => 11, // Mantenimiento mensual
                        'quantity' => 1,
                        'unit_price' => 150.00,
                        'subtotal' => 150.00
                    ],
                    [
                        'product_id' => 5, // Impresora láser
                        'quantity' => 1,
                        'unit_price' => 200.00,
                        'subtotal' => 200.00
                    ]
                ]
            ],
            [
                'user_id' => $adminId,
                'customer_id' => 5, // Luis Rodríguez
                'company_id' => 1,
                'paper_total_price' => 180.00,
                'paper_days' => '15 días',
                'paper_status' => true,
                'created_at' => Carbon::now()->subDays(2),
                'products' => [
                    [
                        'product_id' => 4, // Monitor 24"
                        'quantity' => 1,
                        'unit_price' => 180.00,
                        'subtotal' => 180.00
                    ]
                ]
            ],
            [
                'user_id' => $adminId,
                'customer_id' => 10, // Elena Sánchez
                'company_id' => 1,
                'paper_total_price' => 310.00,
                'paper_days' => '30 días',
                'paper_status' => false,
                'created_at' => Carbon::now()->subDays(1),
                'products' => [
                    [
                        'product_id' => 2, // Laptop HP
                        'quantity' => 1,
                        'unit_price' => 1200.00,
                        'subtotal' => 1200.00
                    ],
                    [
                        'product_id' => 12, // Instalación de software
                        'quantity' => 2,
                        'unit_price' => 50.00,
                        'subtotal' => 100.00
                    ]
                ]
            ],
            [
                'user_id' => $adminId,
                'customer_id' => 15, // Andrés Morales
                'company_id' => 1,
                'paper_total_price' => 435.00,
                'paper_days' => '10 días',
                'paper_status' => true,
                'created_at' => Carbon::now(),
                'products' => [
                    [
                        'product_id' => 3, // Teclado mecánico
                        'quantity' => 2,
                        'unit_price' => 75.00,
                        'subtotal' => 150.00
                    ],
                    [
                        'product_id' => 7, // Memoria RAM 8GB
                        'quantity' => 4,
                        'unit_price' => 35.00,
                        'subtotal' => 140.00
                    ],
                    [
                        'product_id' => 13, // Configuración de red
                        'quantity' => 1,
                        'unit_price' => 80.00,
                        'subtotal' => 80.00
                    ],
                    [
                        'product_id' => 9, // Router WiFi
                        'quantity' => 1,
                        'unit_price' => 80.00,
                        'subtotal' => 80.00
                    ]
                ]
            ]
        ];

        foreach ($papers as $paperData) {
            // Crear el paper
            $paper = Paper::create([
                'user_id' => $paperData['user_id'],
                'customer_id' => $paperData['customer_id'],
                'company_id' => $paperData['company_id'],
                'paper_total_price' => $paperData['paper_total_price'],
                'paper_days' => $paperData['paper_days'],
                'paper_status' => $paperData['paper_status'],
                'created_at' => $paperData['created_at']
            ]);

            // Adjuntar productos con datos pivot
            foreach ($paperData['products'] as $product) {
                $paper->products()->attach($product['product_id'], [
                    'quantity' => $product['quantity'],
                    'unit_price' => $product['unit_price'],
                    'subtotal' => $product['subtotal']
                ]);
            }
        }
    }
}

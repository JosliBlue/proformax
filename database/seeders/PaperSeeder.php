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
        // Cotizaciones TechNova Solutions (empresa 1)
        $papers = [
            [
                'user_id' => 1,
                'customer_id' => 1,
                'company_id' => 1,
                'paper_total_price' => 1810.00,
                'paper_days' => 7,
                'created_at' => Carbon::now()->subDays(5),
                'products' => [
                    ['product_id' => 1, 'quantity' => 1, 'unit_price' => 1450.00, 'subtotal' => 1450.00],
                    ['product_id' => 4, 'quantity' => 2, 'unit_price' => 60.00, 'subtotal' => 120.00],
                    ['product_id' => 2, 'quantity' => 1, 'unit_price' => 320.00, 'subtotal' => 320.00],
                ]
            ],
            [
                'user_id' => 2,
                'customer_id' => 2,
                'company_id' => 1,
                'paper_total_price' => 275.00,
                'paper_days' => 3,
                'created_at' => Carbon::now()->subDays(2),
                'products' => [
                    ['product_id' => 3, 'quantity' => 2, 'unit_price' => 95.00, 'subtotal' => 190.00],
                    ['product_id' => 5, 'quantity' => 1, 'unit_price' => 180.00, 'subtotal' => 180.00],
                ]
            ],
            [
                'user_id' => 3,
                'customer_id' => 3,
                'company_id' => 1,
                'paper_total_price' => 320.00,
                'paper_days' => 5,
                'created_at' => Carbon::now()->subDays(8),
                'products' => [
                    ['product_id' => 2, 'quantity' => 1, 'unit_price' => 320.00, 'subtotal' => 320.00],
                ]
            ],
            [
                'user_id' => 1,
                'customer_id' => 4,
                'company_id' => 1,
                'paper_total_price' => 180.00,
                'paper_days' => 2,
                'created_at' => Carbon::now()->subDays(10),
                'products' => [
                    ['product_id' => 5, 'quantity' => 1, 'unit_price' => 180.00, 'subtotal' => 180.00],
                ]
            ],
            [
                'user_id' => 2,
                'customer_id' => 1,
                'company_id' => 1,
                'paper_total_price' => 1550.00,
                'paper_days' => 6,
                'created_at' => Carbon::now()->subDays(12),
                'products' => [
                    ['product_id' => 1, 'quantity' => 1, 'unit_price' => 1450.00, 'subtotal' => 1450.00],
                    ['product_id' => 3, 'quantity' => 1, 'unit_price' => 95.00, 'subtotal' => 95.00],
                    ['product_id' => 4, 'quantity' => 1, 'unit_price' => 60.00, 'subtotal' => 60.00],
                ]
            ],
            [
                'user_id' => 3,
                'customer_id' => 2,
                'company_id' => 1,
                'paper_total_price' => 180.00,
                'paper_days' => 4,
                'created_at' => Carbon::now()->subDays(15),
                'products' => [
                    ['product_id' => 5, 'quantity' => 1, 'unit_price' => 180.00, 'subtotal' => 180.00],
                ]
            ],
            [
                'user_id' => 1,
                'customer_id' => 3,
                'company_id' => 1,
                'paper_total_price' => 155.00,
                'paper_days' => 2,
                'created_at' => Carbon::now()->subDays(18),
                'products' => [
                    ['product_id' => 3, 'quantity' => 1, 'unit_price' => 95.00, 'subtotal' => 95.00],
                    ['product_id' => 4, 'quantity' => 1, 'unit_price' => 60.00, 'subtotal' => 60.00],
                ]
            ],
            [
                'user_id' => 2,
                'customer_id' => 4,
                'company_id' => 1,
                'paper_total_price' => 320.00,
                'paper_days' => 7,
                'created_at' => Carbon::now()->subDays(20),
                'products' => [
                    ['product_id' => 2, 'quantity' => 1, 'unit_price' => 320.00, 'subtotal' => 320.00],
                ]
            ],
            [
                'user_id' => 3,
                'customer_id' => 1,
                'company_id' => 1,
                'paper_total_price' => 120.00,
                'paper_days' => 1,
                'created_at' => Carbon::now()->subDays(22),
                'products' => [
                    ['product_id' => 4, 'quantity' => 2, 'unit_price' => 60.00, 'subtotal' => 120.00],
                ]
            ],
            [
                'user_id' => 1,
                'customer_id' => 2,
                'company_id' => 1,
                'paper_total_price' => 1450.00,
                'paper_days' => 9,
                'created_at' => Carbon::now()->subDays(25),
                'products' => [
                    ['product_id' => 1, 'quantity' => 1, 'unit_price' => 1450.00, 'subtotal' => 1450.00],
                ]
            ],
            [
                'user_id' => 2,
                'customer_id' => 3,
                'company_id' => 1,
                'paper_total_price' => 155.00,
                'paper_days' => 2,
                'created_at' => Carbon::now()->subDays(28),
                'products' => [
                    ['product_id' => 3, 'quantity' => 1, 'unit_price' => 95.00, 'subtotal' => 95.00],
                    ['product_id' => 4, 'quantity' => 1, 'unit_price' => 60.00, 'subtotal' => 60.00],
                ]
            ],
            // Cotizaciones ConstruRed S.A. (empresa 2)
            [
                'user_id' => 4,
                'customer_id' => 5,
                'company_id' => 2,
                'paper_total_price' => 1250.00,
                'paper_days' => 10,
                'created_at' => Carbon::now()->subDays(4),
                'products' => [
                    ['product_id' => 6, 'quantity' => 50, 'unit_price' => 12.50, 'subtotal' => 625.00],
                    ['product_id' => 9, 'quantity' => 2, 'unit_price' => 250.00, 'subtotal' => 500.00],
                    ['product_id' => 8, 'quantity' => 5, 'unit_price' => 18.00, 'subtotal' => 90.00],
                    ['product_id' => 7, 'quantity' => 100, 'unit_price' => 0.45, 'subtotal' => 45.00],
                ]
            ],
            [
                'user_id' => 5,
                'customer_id' => 6,
                'company_id' => 2,
                'paper_total_price' => 800.00,
                'paper_days' => 5,
                'created_at' => Carbon::now()->subDays(1),
                'products' => [
                    ['product_id' => 10, 'quantity' => 2, 'unit_price' => 400.00, 'subtotal' => 800.00],
                ]
            ],
            [
                'user_id' => 6,
                'customer_id' => 7,
                'company_id' => 2,
                'paper_total_price' => 36.00,
                'paper_days' => 2,
                'created_at' => Carbon::now()->subDays(7),
                'products' => [
                    ['product_id' => 7, 'quantity' => 80, 'unit_price' => 0.45, 'subtotal' => 36.00],
                ]
            ],
            [
                'user_id' => 4,
                'customer_id' => 8,
                'company_id' => 2,
                'paper_total_price' => 250.00,
                'paper_days' => 3,
                'created_at' => Carbon::now()->subDays(9),
                'products' => [
                    ['product_id' => 9, 'quantity' => 1, 'unit_price' => 250.00, 'subtotal' => 250.00],
                ]
            ],
            [
                'user_id' => 5,
                'customer_id' => 5,
                'company_id' => 2,
                'paper_total_price' => 625.00,
                'paper_days' => 6,
                'created_at' => Carbon::now()->subDays(11),
                'products' => [
                    ['product_id' => 6, 'quantity' => 50, 'unit_price' => 12.50, 'subtotal' => 625.00],
                ]
            ],
            [
                'user_id' => 6,
                'customer_id' => 6,
                'company_id' => 2,
                'paper_total_price' => 36.00,
                'paper_days' => 2,
                'created_at' => Carbon::now()->subDays(13),
                'products' => [
                    ['product_id' => 7, 'quantity' => 80, 'unit_price' => 0.45, 'subtotal' => 36.00],
                ]
            ],
            [
                'user_id' => 4,
                'customer_id' => 7,
                'company_id' => 2,
                'paper_total_price' => 90.00,
                'paper_days' => 2,
                'created_at' => Carbon::now()->subDays(15),
                'products' => [
                    ['product_id' => 8, 'quantity' => 5, 'unit_price' => 18.00, 'subtotal' => 90.00],
                ]
            ],
            [
                'user_id' => 5,
                'customer_id' => 8,
                'company_id' => 2,
                'paper_total_price' => 400.00,
                'paper_days' => 8,
                'created_at' => Carbon::now()->subDays(18),
                'products' => [
                    ['product_id' => 10, 'quantity' => 1, 'unit_price' => 400.00, 'subtotal' => 400.00],
                ]
            ],
            [
                'user_id' => 6,
                'customer_id' => 5,
                'company_id' => 2,
                'paper_total_price' => 250.00,
                'paper_days' => 4,
                'created_at' => Carbon::now()->subDays(20),
                'products' => [
                    ['product_id' => 9, 'quantity' => 1, 'unit_price' => 250.00, 'subtotal' => 250.00],
                ]
            ],
            [
                'user_id' => 4,
                'customer_id' => 6,
                'company_id' => 2,
                'paper_total_price' => 625.00,
                'paper_days' => 6,
                'created_at' => Carbon::now()->subDays(22),
                'products' => [
                    ['product_id' => 6, 'quantity' => 50, 'unit_price' => 12.50, 'subtotal' => 625.00],
                ]
            ],
            [
                'user_id' => 5,
                'customer_id' => 7,
                'company_id' => 2,
                'paper_total_price' => 90.00,
                'paper_days' => 2,
                'created_at' => Carbon::now()->subDays(25),
                'products' => [
                    ['product_id' => 8, 'quantity' => 5, 'unit_price' => 18.00, 'subtotal' => 90.00],
                ]
            ],
            [
                'user_id' => 6,
                'customer_id' => 8,
                'company_id' => 2,
                'paper_total_price' => 400.00,
                'paper_days' => 8,
                'created_at' => Carbon::now()->subDays(28),
                'products' => [
                    ['product_id' => 10, 'quantity' => 1, 'unit_price' => 400.00, 'subtotal' => 400.00],
                ]
            ],
        ];
        foreach ($papers as $paperData) {
            $paper = Paper::create([
                'user_id' => $paperData['user_id'],
                'customer_id' => $paperData['customer_id'],
                'company_id' => $paperData['company_id'],
                'paper_total_price' => $paperData['paper_total_price'],
                'paper_days' => $paperData['paper_days'],
                'created_at' => $paperData['created_at'],
                'updated_at' => $paperData['created_at'],
                'is_draft' => false,
                'paper_date' => $paperData['created_at']->format('Y-m-d'),
            ]);
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

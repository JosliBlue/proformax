<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::create([
            'company_name' => 'Giga Compania',
            'company_primary_color' => '#8a090c',
            'company_secondary_color' => '#53abc1',
            'company_logo_path' => 'companies/giga_compania.webp',
            'company_primary_text_color' => '#FFFFFF',
            'company_secondary_text_color' => '#000000'
        ]);
    }
}

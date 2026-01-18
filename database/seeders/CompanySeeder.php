<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Empresa 1: VM Metalmecanica
        Company::create([
            'company_name' => 'VM Metalmecanica',
            'company_primary_color' => '#8a090c',
            'company_secondary_color' => '#53abc1',
            'company_logo_path' => 'companies/vmmetalmecanica.webp',
            'company_primary_text_color' => '#FFFFFF',
            'company_secondary_text_color' => '#212121'
        ]);
        // Empresa 2: Arte Parquet
        Company::create([
            'company_name' => 'Arte Parquet',
            'company_primary_color' => '#bf360c',
            'company_secondary_color' => '#ffd600',
            'company_logo_path' => 'companies/arteparquet.webp',
            'company_primary_text_color' => '#FFFFFF',
            'company_secondary_text_color' => '#263238'
        ]);
        // Empresa 3: Empresa DEMO
        Company::create([
            'company_name' => 'Empresa DEMO',
            'company_primary_color' => '#549bf5',
            'company_secondary_color' => '#bfdbfe',
            'company_logo_path' => 'companies/_01_proformax.webp',
            'company_primary_text_color' => '#FFFFFF',
            'company_secondary_text_color' => '#000000'
        ]);

    }
}

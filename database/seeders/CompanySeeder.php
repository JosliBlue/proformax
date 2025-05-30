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
        // Empresa 1: Giga compania
        Company::create([
            'company_name' => 'Giga Compania',
            'company_primary_color' => '#8a090c',
            'company_secondary_color' => '#53abc1',
            'company_logo_path' => 'companies/giga_compania.webp',
            'company_primary_text_color' => '#FFFFFF',
            'company_secondary_text_color' => '#212121'
        ]);
        // Empresa 2: Cositas
        Company::create([
            'company_name' => 'ArseAccesorios',
            'company_primary_color' => '#bf360c',
            'company_secondary_color' => '#ffd600',
            'company_logo_path' => 'companies/construred_logo.webp',
            'company_primary_text_color' => '#FFFFFF',
            'company_secondary_text_color' => '#263238'
        ]);
    }
}

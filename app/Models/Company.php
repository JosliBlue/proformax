<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $fillable = [
        'company_name',
        'company_logo_path',
        'company_primary_color',
        'company_secondary_color',
        'company_primary_text_color',
        'company_secondary_text_color'
    ];

    public static function default(): Company
    {
        return new self([
            'company_name' => 'Proformax',
            'company_logo_path' => 'companies/_01_proformax.webp',
            'company_primary_color' => '#549bf5', //azulito
            'company_secondary_color' => '#bfdbfe', // azulito mas claro
            'company_primary_text_color' => '#FFFFFF',
            'company_secondary_text_color' => '#000000'
        ]);
    }

    public function getLogoUrlAttribute(): string
    {
        // Si no hay ruta en la BD o el archivo no existe en el storage, retorna la predeterminada
        if (!$this->company_logo_path) {
            return '/storage/companies/_01_proformax.webp';
        }
        // Si la ruta ya contiene '/storage/', devuélvela tal cual
        if (str_starts_with($this->company_logo_path, '/storage/')) {
            return $this->company_logo_path;
        }
        // Si el archivo existe en el storage público, retorna la ruta /storage/...
        if (Storage::disk('public')->exists($this->company_logo_path)) {
            return '/storage/' . ltrim($this->company_logo_path, '/');
        }
        // Si no existe, retorna la predeterminada
        return '/storage/companies/_01_proformax.webp';
    }
}

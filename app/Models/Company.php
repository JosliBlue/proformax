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

    // Relaciones
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Métodos
    public function getGerente()
    {
        return $this->users()->where('user_rol', 'gerente')->first();
    }

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
        if ($this->company_logo_path && file_exists(public_path($this->company_logo_path))) {
            return '/' . ltrim($this->company_logo_path);
        }

        return '/companies/_01_proformax.webp';
    }

    public function getLogoUrlAttributeJPG(): string
    {
        if ($this->company_logo_path) {
            // Intentar con la versión JPG primero (compatible con Dompdf)
            $jpgPath = preg_replace('/\.webp$/i', '.jpg', $this->company_logo_path);
            if (file_exists(public_path($jpgPath))) {
                return '/' . ltrim($jpgPath);
            }
            
            // Si no hay JPG, intentar con el archivo original
            if (file_exists(public_path($this->company_logo_path))) {
                return '/' . ltrim($this->company_logo_path);
            }
        }

        return '/companies/_01_proformax.jpg';
    }
}

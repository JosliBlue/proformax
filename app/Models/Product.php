<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Product para manejar los productos/servicios del sistema
 *
 * @property int $id
 * @property string $product_name
 * @property string $product_type
 * @property float $product_price
 * @property bool $product_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;


    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_name',   // Nombre del producto/servicio
        'product_type',    // Tipo (producto/servicio)
        'product_price',   // Precio del producto
        'product_status'   // Estado del producto (activo/inactivo)
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'product_price' => 'decimal:2', // Convertir a decimal con 2 decimales
        'product_type' => ProductType::class, // Que el tipo este dentro de esas opciones del enum
        'product_status' => 'boolean'   // Convertir a booleano
    ];

    /**
     * Verifica si el producto es de tipo "producto".
     *
     * @return bool
     */
    public function isProduct()
    {
        return $this->product_type === ProductType::PRODUCTO;
    }

    /**
     * Verifica si el producto es de tipo "servicio".
     *
     * @return bool
     */
    public function isService()
    {
        return $this->product_type === ProductType::SERVICIO;
    }

    /**
     * Verifica si el producto está activo.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->product_status === true;
    }

    /**
     * Formatea el precio con el símbolo de moneda.
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->product_price, 2);
    }

    /**
     * Scope para filtrar productos activos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('product_status', true);
    }

    /**
     * Scope para filtrar por tipo de producto.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('product_type', $type);
    }
}

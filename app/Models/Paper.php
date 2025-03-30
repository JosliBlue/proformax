<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Paper para manejar los documentos del sistema
 *
 * @property int $id
 * @property int $user_id
 * @property int $customer_id
 * @property float $paper_total_price
 * @property string $paper_days
 * @property bool $paper_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 */
class Paper extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',            // ID del usuario asociado
        'customer_id',        // ID del cliente asociado
        'paper_total_price',  // Precio total del documento
        'paper_days',         // Días asociados al documento
        'paper_status'        // Estado del documento (activo/inactivo)
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'paper_total_price' => 'decimal:2', // Convertir a decimal con 2 decimales
        'paper_status' => 'boolean'         // Convertir a booleano
    ];

    /**
     * Relación con el usuario que creó el documento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el cliente asociado al documento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relación muchos-a-muchos con los productos/servicios del documento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(PaperProduct::class)
            ->withPivot(['quantity', 'unit_price', 'subtotal'])
            ->withTimestamps();
    }

    /**
     * Verifica si el documento está activo.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->paper_status === true;
    }

    /**
     * Formatea el precio total con el símbolo de moneda.
     *
     * @return string
     */
    public function getFormattedTotalPriceAttribute()
    {
        return '$' . number_format($this->paper_total_price, 2);
    }

    /**
     * Scope para filtrar documentos activos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('paper_status', true);
    }
}

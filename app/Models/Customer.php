<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Modelo Customer para manejar los clientes del sistema
 *
 * @property int $id
 * @property string $customer_name
 * @property string $customer_lastname
 * @property string $customer_phone
 * @property string $customer_email
 * @property bool $customer_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Customer extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',      // Nombre del cliente
        'customer_lastname',  // Apellido del cliente
        'customer_phone',     // Teléfono del cliente
        'customer_email',     // Email del cliente
        'customer_status',     // Estado del cliente (activo/inactivo)
        'company_id'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'customer_status' => 'boolean' // Convertir a booleano
    ];

    /**
     * Relación con los papers (documentos) asociados al cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function papers()
    {
        return $this->hasMany(Paper::class);
    }

    /**
     * Obtiene el nombre completo del cliente.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->customer_name} {$this->customer_lastname}";
    }

    /**
     * Verifica si el cliente está activo.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->customer_status === true;
    }

    /**
     * Scope para filtrar clientes activos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('customer_status', true);
    }
    public function getFullName()
    {
        return $this->customer_name . ' ' . $this->customer_lastname;
    }
    public function scopeForCompany(Builder $query, $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'customer_name',
        'customer_lastname',
        'customer_phone',
        'customer_email',
    ];

    /**
     * Relación con los papers (documentos) asociados al cliente.
     */
    public function papers()
    {
        return $this->hasMany(Paper::class, 'customer_id');
    }
}

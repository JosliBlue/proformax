<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    public function proformas()
    {
        return $this->belongsToMany(Proforma::class, 'proforma_productos')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}

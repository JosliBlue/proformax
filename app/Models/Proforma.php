<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $table = 'proformas';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'proforma_productos')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal');
    }
}

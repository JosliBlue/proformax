<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    public function proformas()
    {
        return $this->hasMany(Proforma::class, 'cliente_id');
    }
}

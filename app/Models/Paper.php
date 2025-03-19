<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'paper_total_price',
        'user_id',
        'customer_id',
    ];

    /**
     * Relación con el usuario que creó el paper.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el cliente asociado al paper.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relación con los productos asociados al paper.
     */
    public function papersProducts()
    {
        return $this->hasMany(PaperProduct::class, 'paper_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperProduct extends Model
{
    protected $table = 'papers_products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'quantity',
        'unit_price',
        'subtotal',
        'paper_id',
        'product_id',
    ];

    /**
     * Relación con el paper asociado.
     */
    public function paper()
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }

    /**
     * Relación con el producto asociado.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

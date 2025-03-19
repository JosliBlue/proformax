<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
    ];

    /**
     * Relación con los papers_products (productos asociados a un paper).
     */
    public function papersProducts()
    {
        return $this->hasMany(PaperProduct::class, 'product_id');
    }
}

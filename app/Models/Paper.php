<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'paper_total_price',
        'paper_days',
        'company_id',
        'is_draft', // <-- permitir asignación masiva
        'paper_date', // <-- nueva columna editable por el usuario
    ];

    protected $casts = [
        'paper_total_price' => 'decimal:2',
        'is_draft' => 'boolean' // <-- casteo booleano
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'papers_products')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }

    /**
     * Scope para filtrar papers por compañía
     */
    public function scopeForCompany(Builder $query, $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    public function isActive()
    {
        return $this->paper_status === true;
    }

    public function getFormattedTotalPriceAttribute()
    {
        return '$' . number_format($this->paper_total_price, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('paper_status', true);
    }
    // En tu modelo Paper
    public function getIsActiveAttribute()
    {
        $date = $this->paper_date ? \Carbon\Carbon::parse($this->paper_date) : $this->created_at;
        $expirationDate = $date->copy()->addDays($this->paper_days);
        return now()->lte($expirationDate);
    }
}

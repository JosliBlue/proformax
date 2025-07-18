<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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

    protected $dates = [
        'paper_date'
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

    public function getIsActiveAttribute()
    {
        if (!$this->paper_date) {
            return Carbon::now()->diffInDays($this->created_at->addDays($this->paper_days), false) >= 0;
        }
        return Carbon::now()->diffInDays(Carbon::parse($this->paper_date)->addDays($this->paper_days), false) >= 0;
    }

    public function scopeForCompany(Builder $query, $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }
}

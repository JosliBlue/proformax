<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_lastname',
        'customer_cedula',
        'customer_phone',
        'customer_email',
        'customer_status',
        'company_id'
    ];

    protected $casts = [
        'customer_status' => 'boolean'
    ];

    public function papers()
    {
        return $this->hasMany(Paper::class);
    }

    public function getFullName()
    {
        return $this->customer_name . ' ' . $this->customer_lastname;
    }

    public function scopeForCompany(Builder $query, $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeActive($query)
    {
        return $query->where('customer_status', true);
    }
}

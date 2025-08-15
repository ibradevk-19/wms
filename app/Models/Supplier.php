<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $fillable = [
        'name',
        'identifier',
        'phone',
        'email',
        'address',
        'city',
        'country',
        'payment_method',
        'status',
        'notes',
    ];

    public function transactions()
    {
        return $this->hasMany(SupplierTransaction::class);
    }

    public function getBalanceAttribute()
    {
        $supplyTotal = $this->transactions()->where('type', 'supply_invoice')->sum('amount');
        $paymentsTotal = $this->transactions()->where('type', 'payment')->sum('amount');

        return $supplyTotal - $paymentsTotal;
    }
}
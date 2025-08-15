<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = [
        'plate_number',
        'driver_name',
        'driver_phone',
        'is_active',
    ];

    public function supplyInvoices()
    {
        return $this->hasMany(SupplyInvoice::class);
    }
}

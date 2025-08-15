<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'code', 'location', 'status', 'capacity', 'notes'];

    public function items()
    {
        return $this->hasMany(WarehouseItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseProductBalance extends Model
{
      protected $fillable = [
        'warehouse_id',
        'product_id',
        'quantity',
        'total_weight',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

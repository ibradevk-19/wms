<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryAdjustment extends Model
{
      protected $fillable = [
        'warehouse_id', 'product_id', 'recorded_quantity',
        'actual_quantity', 'reason', 'adjustment_date'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }
}

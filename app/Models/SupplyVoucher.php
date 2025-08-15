<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyVoucher extends Model
{
    protected $fillable = ['warehouse_id', 'reference_no', 'supplier_name', 'supply_date', 'notes'];

    public function items()
    {
        return $this->hasMany(SupplyVoucherItem::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}

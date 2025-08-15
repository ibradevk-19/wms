<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyInvoiceItem extends Model
{
    protected $fillable = [
        'supply_invoice_id',
        'product_id',
        'unit_id',
        'pallets_count',
        'quantity_per_pallet',
        'total_weight',
    ];

    // العلاقات
    public function invoice()
    {
        return $this->belongsTo(SupplyInvoice::class, 'supply_invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // كمية إجمالية محسوبة (وليس محفوظة في الجدول)
    public function getTotalQuantityAttribute()
    {
        return $this->pallets_count * $this->quantity_per_pallet;
    }
}

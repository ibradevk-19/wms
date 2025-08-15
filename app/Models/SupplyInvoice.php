<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyInvoice extends Model
{
   protected $fillable = [
        'invoice_number',
        'invoice_date',
        'supplier_id',
        'truck_id',
        'warehouse_id',
        'notes',
    ];

    // العلاقات
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(SupplyInvoiceItem::class);
    }
}

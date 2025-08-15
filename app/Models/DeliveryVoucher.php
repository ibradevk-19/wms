<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryVoucher extends Model
{
    protected $fillable = ['warehouse_id', 'reference_no', 'recipient_name', 'delivery_date', 'notes'];

    public function items()
    {
        return $this->hasMany(DeliveryVoucherItem::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}

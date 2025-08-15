<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyVoucherItem extends Model
{
    protected $fillable = ['supply_voucher_id', 'product_id', 'pallets', 'qty_per_pallet', 'total_qty', 'weight_gram'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function voucher()
    {
        return $this->belongsTo(SupplyVoucher::class, 'supply_voucher_id');
    }
}

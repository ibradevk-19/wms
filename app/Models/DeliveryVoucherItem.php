<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryVoucherItem extends Model
{
    protected $fillable = ['delivery_voucher_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function voucher()
    {
        return $this->belongsTo(DeliveryVoucher::class, 'delivery_voucher_id');
    }
}

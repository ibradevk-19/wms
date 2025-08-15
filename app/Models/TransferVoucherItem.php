<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferVoucherItem extends Model
{
       protected $fillable = ['transfer_voucher_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function voucher()
    {
        return $this->belongsTo(TransferVoucher::class);
    }
}

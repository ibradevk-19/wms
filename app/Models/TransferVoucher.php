<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferVoucher extends Model
{
      protected $fillable = ['from_warehouse_id', 'to_warehouse_id', 'reference_no', 'transfer_date', 'notes'];

        public function items()
        {
            return $this->hasMany(TransferVoucherItem::class);
        }

        public function fromWarehouse()
        {
            return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
        }

        public function toWarehouse()
        {
            return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
        }
}

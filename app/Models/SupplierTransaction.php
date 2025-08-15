<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierTransaction extends Model
{

        protected $fillable = [
            'supplier_id',
            'type',
            'reference',
            'amount',
            'description',
            'transaction_date',
        ];

        public function supplier()
        {
            return $this->belongsTo(Supplier::class);
        }
    }

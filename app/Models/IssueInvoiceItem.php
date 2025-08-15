<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueInvoiceItem extends Model
{
    protected $fillable = [
        'issue_invoice_id', 'product_id', 'unit_id',
        'quantity', 'stock_unit_quantity', 'remarks'
    ];

    public function invoice()
    {
        return $this->belongsTo(IssueInvoice::class, 'issue_invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

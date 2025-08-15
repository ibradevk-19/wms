<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueInvoice extends Model
{
    protected $fillable = [
        'issue_number', 'issue_date', 'warehouse_id',
        'issued_to_type', 'issued_to_id', 'notes',
        'created_by', 'status'
    ];

    public function items()
    {
        return $this->hasMany(IssueInvoiceItem::class);
    }

    public function issuedTo()
    {
        return $this->morphTo('issued_to');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

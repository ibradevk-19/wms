<?php

namespace App\Exports;

use App\Models\SupplierTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierTransactionsExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = SupplierTransaction::with('supplier');

        if (!empty($this->filters['supplier_id'])) {
            $query->where('supplier_id', $this->filters['supplier_id']);
        }

        if (!empty($this->filters['type'])) {
            $query->where('type', $this->filters['type']);
        }

        if (!empty($this->filters['from']) && !empty($this->filters['to'])) {
            $query->whereBetween('transaction_date', [$this->filters['from'], $this->filters['to']]);
        }

        return $query->get()->map(function ($t) {
            return [
                'المورد' => $t->supplier->name,
                'النوع' => $t->type,
                'المرجع' => $t->reference,
                'التاريخ' => $t->transaction_date,
                'الكمية' => $t->amount,
                'الوصف' => $t->description,
            ];
        });
    }

    public function headings(): array
    {
        return ['المورد', 'النوع', 'المرجع', 'التاريخ', 'الكمية', 'الوصف'];
    }
}

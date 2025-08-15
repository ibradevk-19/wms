<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use App\Exports\SupplierTransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class SupplierReportController extends Controller
{

    public function index(Request $request)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $query = SupplierTransaction::with('supplier');

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('transaction_date', [$request->from, $request->to]);
        }

        $transactions = $query->orderByDesc('transaction_date')->get();

        return view('reports.supplier.index', compact('transactions', 'suppliers'));
    }

    public function export(Request $request)
    {
        $filters = $request->all();

        return Excel::download(new SupplierTransactionsExport($filters), 'supplier-transactions.xlsx');
    }

}

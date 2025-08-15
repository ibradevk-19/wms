<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Illuminate\Http\Request;

class SupplierTransactionController extends Controller
{
    public function create(Supplier $supplier)
    {
        return view('suppliers.transactions.create', compact('supplier'));
    }

    public function store(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'type' => 'required|in:supply_invoice,payment,note',
            'reference' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $supplier->transactions()->create($validated);

        return redirect()->route('suppliers.show', $supplier)->with('success', 'تم تسجيل التعامل بنجاح.');
    }

    public function edit(SupplierTransaction $transaction)
    {
        $supplier = $transaction->supplier;
        return view('suppliers.transactions.edit', compact('transaction', 'supplier'));
    }

    public function update(Request $request, SupplierTransaction $transaction)
    {
        $validated = $request->validate([
            'type' => 'required|in:supply_invoice,payment,note',
            'reference' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('suppliers.show', $transaction->supplier_id)
            ->with('success', 'تم تعديل التعامل بنجاح.');
    }

        public function destroy(SupplierTransaction $transaction)
    {
        $supplier = $transaction->supplier;

        $transaction->delete();

        return redirect()->route('suppliers.show', $supplier)->with('success', 'تم حذف التعامل بنجاح.');
    }

}

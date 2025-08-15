<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferVoucher;
use App\Models\TransferVoucherItem;
use App\Models\Warehouse;
use App\Models\Product;

class TransferVoucherController extends Controller
{
    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('transfer_vouchers.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id|different:to_warehouse_id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'reference_no' => 'required|unique:transfer_vouchers',
            'transfer_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $voucher = TransferVoucher::create([
            'from_warehouse_id' => $request->from_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'reference_no' => $request->reference_no,
            'transfer_date' => $request->transfer_date,
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            TransferVoucherItem::create([
                'transfer_voucher_id' => $voucher->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);

            // ⚠️ تحديث المخزون سيتم لاحقًا:
            // - خصم من warehouse_items للمصدر
            // - إضافة للهدف
        }

        return redirect()->route('warehouses.show', $voucher->to_warehouse_id)
            ->with('success', 'تم تحويل الأصناف بنجاح');
    }
}

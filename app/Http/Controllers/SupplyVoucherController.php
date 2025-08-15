<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\SupplyVoucher;
use App\Models\SupplyVoucherItem;
use App\Modles\ProductStock;

class SupplyVoucherController extends Controller
{
    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();

        return view('supply_vouchers.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'reference_no' => 'required|unique:supply_vouchers',
            'supplier_name' => 'required|string|max:255',
            'supply_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.pallets' => 'required|integer|min:1',
            'items.*.qty_per_pallet' => 'required|integer|min:1',
            'items.*.weight_gram' => 'nullable|integer|min:0'
        ]);

        $voucher = SupplyVoucher::create([
            'warehouse_id' => $request->warehouse_id,
            'reference_no' => $request->reference_no,
            'supplier_name' => $request->supplier_name,
            'supply_date' => $request->supply_date,
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            // حساب الكمية الإجمالية
            $totalQty = $item['pallets'] * $item['qty_per_pallet'];

            // إنشاء بند الفاتورة
            SupplyVoucherItem::create([
                'supply_voucher_id' => $voucher->id,
                'product_id' => $item['product_id'],
                'pallets' => $item['pallets'],
                'qty_per_pallet' => $item['qty_per_pallet'],
                'total_qty' => $totalQty,
                'weight_gram' => $item['weight_gram'],
            ]);

            // ✅ تحديث أو إنشاء سجل المخزون
            $existing = \App\Models\WarehouseItem::where('warehouse_id', $voucher->warehouse_id)
                ->where('product_id', $item['product_id'])
                ->first();

            if ($existing) {
                $existing->increment('quantity', $totalQty);
                $existing->last_movement_at = now();
                $existing->save();
            } else {
                \App\Models\WarehouseItem::create([
                    'warehouse_id' => $voucher->warehouse_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $totalQty,
                    'last_movement_at' => now(),
                    'location_inside' => null, // يمكنك تعديل الموقع لاحقًا يدويًا
                ]);
            }

         $stock = ProductStock::firstOrNew(['product_id' => $item['product_id']]);
                    $stock->quantity += $totalQty;
                    $stock->save();
         }

        return redirect()->route('warehouses.show', $voucher->warehouse_id)->with('success', 'تم تسجيل التوريد وتحديث المخزون بنجاح');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarehouseItem;
use App\Models\InventoryAdjustment;
use App\Models\Warehouse;

class InventoryAdjustmentController extends Controller
{
    public function create(Warehouse $warehouse)
    {
        $items = $warehouse->items()->with('product')->get();
        return view('inventory_adjustments.create', compact('warehouse', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'adjustments' => 'required|array|min:1',
            'adjustments.*.product_id' => 'required|exists:products,id',
            'adjustments.*.recorded_quantity' => 'required|integer',
            'adjustments.*.actual_quantity' => 'required|integer|min:0',
            'adjustments.*.reason' => 'nullable|string',
            'adjustment_date' => 'required|date',
        ]);

        foreach ($validated['adjustments'] as $adj) {
            InventoryAdjustment::create([
                'warehouse_id' => $validated['warehouse_id'],
                'product_id' => $adj['product_id'],
                'recorded_quantity' => $adj['recorded_quantity'],
                'actual_quantity' => $adj['actual_quantity'],
                'reason' => $adj['reason'],
                'adjustment_date' => $validated['adjustment_date'],
            ]);

            // تحديث المخزون الفعلي
            WarehouseItem::where('warehouse_id', $validated['warehouse_id'])
                ->where('product_id', $adj['product_id'])
                ->update(['quantity' => $adj['actual_quantity']]);
        }

        return redirect()->route('warehouses.show', $validated['warehouse_id'])->with('success', 'تم تسجيل الجرد وتحديث الكميات بنجاح');
    }
}

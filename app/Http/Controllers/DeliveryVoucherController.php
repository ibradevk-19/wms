<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\DeliveryVoucher;
use App\Models\DeliveryVoucherItem;
use App\Models\ProductStock;

class DeliveryVoucherController extends Controller
{
   public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();

        return view('delivery_vouchers.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'reference_no' => 'required|unique:delivery_vouchers',
            'recipient_name' => 'required|string|max:255',
            'delivery_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $voucher = DeliveryVoucher::create([
            'warehouse_id' => $request->warehouse_id,
            'reference_no' => $request->reference_no,
            'recipient_name' => $request->recipient_name,
            'delivery_date' => $request->delivery_date,
            'notes' => $request->notes,
        ]);

        foreach ($request->items as $item) {
            $productId = $item['product_id'];
            $qty = $item['quantity'];

            // ✅ التحقق من وجود الصنف في المخزن
            $warehouseItem = \App\Models\WarehouseItem::where('warehouse_id', $voucher->warehouse_id)
                ->where('product_id', $productId)
                ->first();

            if (!$warehouseItem) {
                return back()->withErrors(['items' => "الصنف رقم {$productId} غير موجود في هذا المخزن."]);
            }

            // ✅ التحقق من توفر الكمية
            if ($warehouseItem->quantity < $qty) {
                return back()->withErrors(['items' => "الصنف {$warehouseItem->product->name} لا يحتوي على كمية كافية. الكمية المتوفرة: {$warehouseItem->quantity}"]);
            }

            // ✅ إنشاء بند الصرف
            DeliveryVoucherItem::create([
                'delivery_voucher_id' => $voucher->id,
                'product_id' => $productId,
                'quantity' => $qty,
            ]);

            // ✅ خصم الكمية من المخزون
            $warehouseItem->decrement('quantity', $qty);
            $warehouseItem->last_movement_at = now();
            $warehouseItem->save();

            $stock = ProductStock::where('product_id', $item['product_id'])->first();

            if (!$stock || $stock->quantity < $item['quantity']) {
                return back()->withErrors(['items' => "الصنف لا يحتوي على رصيد كافٍ في النظام."]);
            }

            $stock->decrement('quantity', $item['quantity']);
        }

        return redirect()->route('warehouses.show', $voucher->warehouse_id)->with('success', 'تم تسجيل الصرف وتحديث المخزون بنجاح');
    }

}

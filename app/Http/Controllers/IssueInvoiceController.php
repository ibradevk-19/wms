<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IssueInvoice;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\IssueInvoiceItem;
use App\Models\WarehouseProductBalance;
use App\Models\ProductStock;
use App\Models\WarehouseItem;
use DB;

class IssueInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = IssueInvoice::with('warehouse', 'creator')->latest()->paginate(20);
        return view('issue_invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::with('unit')->get();

        return view('issue_invoices.create', compact('warehouses', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issue_date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'issued_to_id' => 'required',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.001',
            'items.*.remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // توليد رقم الفاتورة
            $issueNumber = 'ISS-' . now()->format('Ymd-His') . '-' . rand(100, 999);

            $invoice = IssueInvoice::create([
                'issue_number' => $issueNumber,
                'issue_date' => $validated['issue_date'],
                'warehouse_id' => $validated['warehouse_id'],
                'issued_to_id' => $validated['issued_to_id'],
                'issued_to_type' => 'APP',
                'notes' => $request->notes,
                'created_by' => auth()->id(),
                'status' => 'issued',
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);

                $stockQty = $item['quantity'] * $product->conversion_rate_to_stock_unit; // التحويل لوحدة التخزين

                IssueInvoiceItem::create([
                    'issue_invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'unit_id' => $product->unit_id,
                    'quantity' => $item['quantity'],
                    'stock_unit_quantity' => $stockQty,
                    'remarks' => $item['remarks'] ?? null,
                ]);
                $qty = $item['quantity'];

                $balance =  WarehouseProductBalance::where('warehouse_id',$validated['warehouse_id'])
                                       ->where('product_id',$item['product_id'])->first();
                  $balance->quantity = $balance->quantity - $qty;
                  $balance->save();

                    $stock = ProductStock::firstOrNew(['product_id' => $item['product_id'],'warehouse_id' => $validated['warehouse_id']]);
                 
                    $stock->quantity -= $qty;
                    $stock->save();
                // تخفيض الكمية من جدول رصيد المخزون
                // DB::table('warehouse_product_stocks')
                //     ->where('warehouse_id', $invoice->warehouse_id)
                //     ->where('product_id', $product->id)
                //     ->decrement('quantity', $stockQty);

                // (اختياري) سجل حركة الصنف
                // DB::table('stock_movements')->insert([
                //     'product_id' => $product->id,
                //     'warehouse_id' => $invoice->warehouse_id,
                //     'movement_type' => 'issue',
                //     'quantity' => -$stockQty,
                //     'related_model' => IssueInvoice::class,
                //     'related_id' => $invoice->id,
                //     'movement_date' => $validated['issue_date'],
                //     'created_at' => now(),
                //     'updated_at' => now(),
                // ]);

            
                // ✅ تحديث أو إنشاء سجل المخزون
                $existing = WarehouseItem::where('warehouse_id', $validated['warehouse_id'])
                    ->where('product_id', $item['product_id'])
                    ->first();

                if ($existing) {
                    $existing->quantity = $existing->quantity - $qty;
                    $existing->last_movement_at = now();
                    $existing->save();
                } else {
                    WarehouseItem::create([
                        'warehouse_id' => $validated['warehouse_id'],
                        'product_id' => $item['product_id'],
                        'quantity' => $qty,
                        'last_movement_at' => now(),
                        'location_inside' => null, // يمكنك تعديل الموقع لاحقًا يدويًا
                    ]);
                }
            }
        });

        return redirect()->route('issue-invoices.index')->with('success', 'تم حفظ فاتورة الصرف بنجاح');
    }


    /**
     * Display the specified resource.
     */
    public function show(IssueInvoice $issueInvoice)
    {
        $issueInvoice->load(['items.product.unit', 'warehouse','creator']);

        return view('issue_invoices.show', compact('issueInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

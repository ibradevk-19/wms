<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplyInvoice;
use App\Models\Supplier;
use App\Models\Truck;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Unit;
use App\Models\SupplyInvoiceItem;
use App\Models\SupplierTransaction;
use App\Models\WarehouseProductBalance;
use App\Exports\SupplyInvoiceReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ProductStock;
use App\Models\WarehouseItem;
use DB;

class SupplyInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = SupplyInvoice::with(['supplier', 'warehouse', 'truck'])
            ->when($request->supplier_id, fn($q) => $q->where('supplier_id', $request->supplier_id))
            ->when($request->warehouse_id, fn($q) => $q->where('warehouse_id', $request->warehouse_id))
            ->when($request->date_from, fn($q) => $q->whereDate('invoice_date', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('invoice_date', '<=', $request->date_to))
            ->latest()
            ->get();

        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();

        return view('supply_invoices.index', compact('invoices', 'suppliers', 'warehouses'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $trucks = Truck::all();
        $warehouses = Warehouse::all();
        $products  = Product::all();
        $units = Unit::all();
        return view('supply_invoices.create')->with([
            'suppliers' => $suppliers,
            'trucks' => $trucks,
            'warehouses' => $warehouses,
            'products' => $products,
            'units' => $units,
         
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:supply_invoices,invoice_number',
            'invoice_date'   => 'required|date',
            'supplier_id'    => 'required|exists:suppliers,id',
            'truck_id'       => 'nullable|exists:trucks,id',
            'warehouse_id'   => 'required|exists:warehouses,id',
            'items'                          => 'required|array|min:1',
            'items.*.product_id'             => 'required|exists:products,id',
            'items.*.unit_id'                => 'required|exists:units,id',
            'items.*.pallets_count'          => 'required|integer|min:1',
            'items.*.quantity_per_pallet'    => 'required|integer|min:1',
            'items.*.total_weight'           => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // 1) إنشاء الفاتورة
            $invoice = SupplyInvoice::create([
                'invoice_number' => $request->invoice_number,
                'invoice_date'   => $request->invoice_date,
                'supplier_id'    => $request->supplier_id,
                'truck_id'       => $request->truck_id,
                'warehouse_id'   => $request->warehouse_id,
                'notes'          => $request->notes,
            ]);

            // 2) إدخال الأصناف + 3) تحديث رصيد المخزون (بدون DB::raw)
            foreach ($request->items as $item) {
                SupplyInvoiceItem::create([
                    'supply_invoice_id'   => $invoice->id,
                    'product_id'          => $item['product_id'],
                    'unit_id'             => $item['unit_id'],
                    'pallets_count'       => $item['pallets_count'],
                    'quantity_per_pallet' => $item['quantity_per_pallet'],
                    'total_weight'        => $item['total_weight'],
                ]);

                //$qty = (int)$item['pallets_count'] * (int)$item['quantity_per_pallet']; // add new colum
                $qty = (int)$item['pallets_count'];
                $wgt = (float)$item['total_weight'];

            
                // ✅ تحديث أو إنشاء سجل المخزون
            $existing = WarehouseItem::where('warehouse_id', $request->warehouse_id)
                ->where('product_id', $item['product_id'])
                ->first();

            if ($existing) {
                $existing->quantity = $existing->quantity + $qty;
                $existing->last_movement_at = now();
                $existing->save();
            } else {
                WarehouseItem::create([
                    'warehouse_id' => $request->warehouse_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $qty,
                    'last_movement_at' => now(),
                    'location_inside' => null, // يمكنك تعديل الموقع لاحقًا يدويًا
                ]);
            }

                // أنشئ/اجلب رصيد المخزون ثم زد القيم
                $balance = WarehouseProductBalance::firstOrCreate(
                    [
                        'warehouse_id' => $request->warehouse_id,
                        'product_id'   => $item['product_id'],
                    ],
                    [
                        'quantity'     => 0,
                        'total_weight' => 0,
                    ]
                );

                // خيار آمن ومتوافق مع SQLite
                $balance->quantity     = ($balance->quantity ?? 0) + $qty;
                $balance->total_weight = ($balance->total_weight ?? 0) + $wgt;
                $balance->save();

                // $stock = ProductStock::where('warehouse_id', $request->warehouse_id)->where('product_id', $item['product_id'])->first();
                // $stock->update([
                //     'quantity' => $stock->quantity += $qty
                // ]);

                
                    $stock = ProductStock::firstOrNew(['product_id' => $item['product_id'],'warehouse_id' => $request->warehouse_id]);
                 
                    $stock->quantity += $qty;
                    $stock->save();
                              
                               
                // أو يمكن استخدام:
                // $balance->increment('quantity', $qty);
                // $balance->increment('total_weight', $wgt);
                //supplier-transactions make supplier-transactions

                SupplierTransaction::create([
                    'type' => 'supply_invoice',
                    'reference' => $request->invoice_number,
                    'amount' => $qty,
                    'description' => $request->notes,
                    'transaction_date' => now()
                ]);
            }

            DB::commit();
            return redirect()->route('supply_invoices.index')->with('success', 'تم حفظ الفاتورة بنجاح');
        } catch (\Throwable $e) {
            DB::rollBack();
            // لا تستخدم dd في الإنتاج
            dd($e);
            return back()->withInput()->with('error', 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage());
        }
    }

    public function show(SupplyInvoice $supplyInvoice)
    {
        $supplyInvoice->load('supplier', 'truck', 'warehouse', 'items.product', 'items.unit');
        return view('supply_invoices.show', ['invoice' => $supplyInvoice]);
    }


    public function update(Request $request, SupplyInvoice $supplyInvoice)
    {
        $request->validate([
            'invoice_number' => 'required|unique:supply_invoices,invoice_number,' . $supplyInvoice->id,
            'invoice_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_id' => 'required|exists:units,id',
            'items.*.pallets_count' => 'required|integer|min:1',
            'items.*.quantity_per_pallet' => 'required|integer|min:1',
            'items.*.total_weight' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $warehouse_id = $request->warehouse_id;

            // 1️⃣ استرجاع الكميات القديمة وإزالتها من رصيد المخزون
            foreach ($supplyInvoice->items as $oldItem) {
                $oldQty = $oldItem->pallets_count * $oldItem->quantity_per_pallet;
                $oldWeight = $oldItem->total_weight;

                $balance = WarehouseProductBalance::where([
                    'warehouse_id' => $warehouse_id,
                    'product_id' => $oldItem->product_id
                ])->first();

                if ($balance) {
                    $balance->quantity -= $oldQty;
                    $balance->total_weight -= $oldWeight;
                    $balance->save();
                }
            }

            // 2️⃣ حذف الأصناف القديمة
            $supplyInvoice->items()->delete();

            // 3️⃣ تحديث بيانات الفاتورة
            $supplyInvoice->update([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'supplier_id' => $request->supplier_id,
                'truck_id' => $request->truck_id,
                'warehouse_id' => $request->warehouse_id,
                'notes' => $request->notes,
            ]);

            // 4️⃣ إدخال الأصناف الجديدة وتحديث المخزون
            foreach ($request->items as $item) {
                $qty = $item['pallets_count'] * $item['quantity_per_pallet'];
                $weight = $item['total_weight'];

                // حفظ العنصر
                SupplyInvoiceItem::create([
                    'supply_invoice_id' => $supplyInvoice->id,
                    'product_id' => $item['product_id'],
                    'unit_id' => $item['unit_id'],
                    'pallets_count' => $item['pallets_count'],
                    'quantity_per_pallet' => $item['quantity_per_pallet'],
                    'total_weight' => $item['total_weight'],
                ]);

                // تحديث رصيد المخزون
                WarehouseProductBalance::updateOrCreate(
                    [
                        'warehouse_id' => $warehouse_id,
                        'product_id' => $item['product_id']
                    ],
                    [
                        'quantity' => DB::raw("quantity + $qty"),
                        'total_weight' => DB::raw("total_weight + $weight")
                    ]
                );
            }

            DB::commit();
            return redirect()->route('supply_invoices.index')->with('success', 'تم تعديل الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء التعديل: ' . $e->getMessage());
        }
    }


    public function report(Request $request)
    {
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();
        $products = Product::all();

        $query = SupplyInvoice::query()->with(['supplier', 'warehouse', 'items']);

        // الفلترة
        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->date_from) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        // تحميل الفواتير و العناصر
        $invoices = $query->get();

        // حساب الإجماليات
        $totalWeight = 0;
        $totalPallets = 0;
        $invoiceCount = $invoices->count();

        foreach ($invoices as $invoice) {
            foreach ($invoice->items as $item) {
                $totalWeight += $item->total_weight;
                $totalPallets += $item->pallets_count;
            }
        }

        return view('supply_invoices.report', compact(
            'suppliers', 'warehouses', 'products',
            'invoices', 'totalWeight', 'totalPallets', 'invoiceCount'
        ));
    }






    public function exportReportExcel(Request $request)
    {
        $data = $this->getFilteredReportData($request);

        return Excel::download(new SupplyInvoiceReportExport($data), 'supply_invoice_report.xlsx');
    }


    private function getFilteredReportData(Request $request): array
    {
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();
        $products = Product::all();

        $query = SupplyInvoice::with(['supplier', 'warehouse', 'items']);

        if ($request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->warehouse_id) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->date_from) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        $invoices = $query->get();

        $totalWeight = 0;
        $totalPallets = 0;
        foreach ($invoices as $invoice) {
            foreach ($invoice->items as $item) {
                $totalWeight += $item->total_weight;
                $totalPallets += $item->pallets_count;
            }
        }

        $invoiceCount = $invoices->count();

        return compact('suppliers', 'warehouses', 'products', 'invoices', 'totalWeight', 'totalPallets', 'invoiceCount');
    }






}

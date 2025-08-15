<?php

namespace App\Imports;

use App\Models\SupplyInvoice;
use App\Models\SupplyInvoiceItem;
use App\Models\WarehouseProductBalance;
use App\Models\WarehouseItem;
use App\Models\Supplier;
use App\Models\Truck;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SupplyInvoicesImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    WithValidation,
    SkipsOnFailure
{
    use SkipsFailures, SkipsErrors;

    /**
     * خريطة أسماء الأعمدة (ادعم أسماء عربية/إنجليزية محتملة)
     */
    protected array $map = [
        'invoice_number'       => ['invoice_number', 'رقم_الفاتورة', 'رقم الفاتورة'],
        'invoice_date'         => ['invoice_date', 'تاريخ_الفاتورة', 'تاريخ الفاتورة'],
        'supplier'             => ['supplier', 'supplier_name', 'المورد', 'اسم_المورد', 'اسم المورد'],
        'truck_plate'          => ['truck_plate', 'رقم_اللوحة', 'رقم اللوحة', 'الشاحنة'],
        'warehouse_code'       => ['warehouse_code', 'رمز_المخزن', 'رمز المخزن'],
        'warehouse'            => ['warehouse', 'اسم_المخزن', 'المخزن'],
        'product'              => ['product', 'product_name', 'الصنف', 'اسم_الصنف', 'اسم الصنف', 'الكود'],
        'unit'                 => ['unit', 'unit_name', 'الوحدة'],
        'pallets_count'        => ['pallets_count', 'عدد_المشاطيح', 'عدد المشاطيح'],
        'quantity_per_pallet'  => ['quantity_per_pallet', 'الكمية_لكل_مشطاح', 'الكمية لكل مشطاح'],
        'total_weight'         => ['total_weight', 'الوزن_الكلي', 'الوزن الكلي'],
    ];

    /**
     * التحقق الأساسي (سنقوم بتحقق أدق داخل الدالة الرئيسية أيضًا)
     */
    public function rules(): array
    {
        return [
            '*.invoice_number' => 'nullable', // قد نولّد الرقم تلقائيًا
        ];
    }

    /**
     * حجم القطعة للقراءة المتقطعة (أداء أفضل للملفات الكبيرة)
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * مساعد: جلب قيمة عمود بالاعتماد على خريطة أسماء محتملة
     */
    protected function col(array $row, string $key, $default = null)
    {
        if (!isset($this->map[$key])) {
            return $default;
        }
        foreach ($this->map[$key] as $candidate) {
            if (array_key_exists($candidate, $row)) {
                return $row[$candidate];
            }
        }
        return $default;
    }

    /**
     * مساعد: تحويل مدخل التاريخ (Excel serial أو نص) إلى Y-m-d
     */
    protected function parseDate($value): string
    {
        if (blank($value)) {
            return now()->toDateString();
        }

        // رقم تسلسلي من Excel
        if (is_numeric($value)) {
            try {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                return Carbon::instance($date)->toDateString();
            } catch (\Throwable $e) {
                // تجاهل وجرّب التحليل النصي
            }
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable $e) {
            return now()->toDateString();
        }
    }

    /**
     * مساعد: حل المخزن بالرمز أولاً ثم الاسم
     * يتطلب وجود عمود code في جدول warehouses
     */
    protected function resolveWarehouse(?string $code, ?string $name): Warehouse
    {
        $code = $code ? trim($code) : null;
        $name = $name ? trim($name) : null;

        if ($code) {
            $w = Warehouse::where('code', $code)->first();
            if ($w) {
                return $w;
            }
        }

        if ($name) {
            return Warehouse::firstOrCreate(['name' => $name,'code' => $code]);
        }

        return Warehouse::firstOrCreate(['name' => 'مخزن غير محدد','code' => "ssss"]);
    }

    /**
     * مساعد: إنشاء مفتاح التجميع (فاتورة واحدة = نفس الشاحنة + رمز المخزن + التاريخ)
     * لو أردتها بدون التاريخ: احذف الجزء الخاص بـ $date من return.
     */
    protected function groupKey(array $row): string
    {
        $plate   = trim((string)($this->col($row, 'truck_plate') ?? 'NO-PLATE'));
        $wCode   = trim((string)($this->col($row, 'warehouse_code') ?? 'NO-WCODE'));
        $dateRaw = $this->col($row, 'invoice_date');
        $date    = $this->parseDate($dateRaw); // Y-m-d

        return $date . '|' . mb_strtoupper($plate) . '|' . mb_strtoupper($wCode);
    }

    /**
     * الدالة الرئيسية لمعالجة الصفوف
     */
    public function collection(Collection $rows)
    {
        // تطبيع المفاتيح والقيم (Trim)
        $normalized = $rows->map(function ($row) {
            $array = [];
            foreach ($row->toArray() as $k => $v) {
                $kk = is_string($k) ? trim($k) : $k;
                $array[$kk] = is_string($v) ? trim($v) : $v;
            }
            return $array;
        });

        // تجميع الصفوف حسب (الشاحنة + رمز المخزن + التاريخ)
        $grouped = $normalized->groupBy(function ($row) {
            $explicitNumber = $this->col($row, 'invoice_number'); // متاح لو أردت تتبعه
            // نستخدم مفتاح التجميع دائمًا حسب طلبك
            $key = $this->groupKey($row);

            // إن رغبت بالاحتفاظ برقم الفاتورة إن وجد لأغراض التتبع:
            if ($explicitNumber) {
                return $key . '|INV:' . $explicitNumber;
            }
            return $key;
        });

        foreach ($grouped as $groupKey => $rowsOfInvoice) {
              try { 
            DB::transaction(function () use ($rowsOfInvoice) {

                $first = $rowsOfInvoice->first();

                // تاريخ
                $invoiceDate = $this->parseDate($this->col($first, 'invoice_date'));

                // شاحنة
                $truckPlate  = $this->col($first, 'truck_plate');
                $driver_name  = $this->col($first, 'driver_name');
                $truckId     = null;
                if ($truckPlate) {
                    $truck   = Truck::firstOrCreate(['plate_number' => trim($truckPlate),'driver_name' => trim($driver_name)]);
                    $truckId = $truck->id;
                }

                // مخزن (بالرمز أولًا)
                $warehouseCode = $this->col($first, 'warehouse_code');
                $warehouseName = $this->col($first, 'warehouse');
                $warehouse     = $this->resolveWarehouse($warehouseCode, $warehouseName);
                 
               
                // مورد
                $supplierName  = $this->col($first, 'supplier');
                $supplier      = Supplier::firstOrCreate(['name' => $supplierName ?: 'KSA']);
 
                // رقم الفاتورة:
                // استخدم الموجود إن كان موجودًا في الصف الأول؛ وإن لم يوجد، ولّده من التاريخ+اللوحة+رمز المخزن
                $explicitNumber = $this->col($first, 'invoice_number');
                $composedNumber = 'IMP-'
                    . str_replace('-', '', $invoiceDate) . '-'
                    . preg_replace('/\s+/', '', mb_strtoupper($truckPlate ?: 'NOPLATE')) . '-'
                    . preg_replace('/\s+/', '', mb_strtoupper($warehouseCode ?: 'NOWC'));

                $invoiceNumber  = $explicitNumber ?: $composedNumber;

                // إنشاء/تحديث الفاتورة
                $invoice = SupplyInvoice::firstOrCreate(
                    ['invoice_number' => $invoiceNumber],
                    [
                        'invoice_date' => $invoiceDate,
                        'supplier_id'  => $supplier->id,
                        'truck_id'     => $truckId,
                        'warehouse_id' => $warehouse->id,
                        'notes'        => null,
                    ]
                );

                // تأكيد التحديث لو الفاتورة موجودة مسبقًا
                // $invoice->update([
                //     'invoice_date' => $invoiceDate,
                //     'supplier_id'  => $supplier->id,
                //     'truck_id'     => $truckId,
                //     'warehouse_id' => $warehouse->id,
                // ]);

                // معالجة عناصر الفاتورة
                foreach ($rowsOfInvoice as $row) {
                    
                    $productNameOrCode = $this->col($row, 'product');
                    $unitName          = $this->col($row, 'unit');
                    $pallets           = (int) ($this->col($row, 'pallets_count') ?? 0);
                    $qtyPerPallet      = (int) ($this->col($row, 'quantity_per_pallet') ?? 0);
                    $totalWeight       = (float)($this->col($row, 'total_weight') ?? 0);
                       
                  
                
                    // تحقق أساسي للصف 
                    if (!$productNameOrCode || !$unitName || $pallets <= 0 ) {
                        // تخطّي الصف غير المكتمل
                        continue;
                    }

                    // جلب/إنشاء الصنف (بدّلها للبحث بالكود لو عندك عمود كود)
                    $product = Product::firstOrCreate(['name' => $productNameOrCode]);
           
                    // جلب/إنشاء الوحدة
                    $unit = Unit::firstOrCreate(['name' => $unitName]);

                    // إنشاء سطر الفاتورة
                   $dd=  SupplyInvoiceItem::create([
                        'supply_invoice_id'   => $invoice->id,
                        'product_id'          => $product->id,
                        'unit_id'             => $unit->id,
                        'pallets_count'       => $pallets,
                        'quantity_per_pallet' => $qtyPerPallet,
                        'total_weight'        => $totalWeight,
                    ]);

                     

                    // تحديث رصيد المخزون (بدون DB::raw) — متوافق مع SQLite
                   // $qty = $pallets * $qtyPerPallet;
                    $qty = $pallets;
                          // ✅ تحديث أو إنشاء سجل المخزون
            $existing = WarehouseItem::where('warehouse_id', $warehouse->id)
                ->where('product_id', $product->id)
                ->first();

            if ($existing) {
                $existing->quantity = $existing->quantity + $qty;
                $existing->last_movement_at = now();
                $existing->save();
            } else {
                WarehouseItem::create([
                    'warehouse_id' => $warehouse->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'last_movement_at' => now(),
                    'location_inside' => null, // يمكنك تعديل الموقع لاحقًا يدويًا
                ]);
            }

                    $balance = WarehouseProductBalance::firstOrCreate(
                        [
                            'warehouse_id' => $invoice->warehouse_id,
                            'product_id'   => $product->id,
                        ],
                        [
                            'quantity'     => 0,
                            'total_weight' => 0,
                        ]
                    );

                    $balance->quantity     = ($balance->quantity ?? 0) + $qty;
                    $balance->total_weight = ($balance->total_weight ?? 0) + $totalWeight;
                    $balance->save();

                    $stock = ProductStock::firstOrNew(['product_id' => $product->id,'warehouse_id' => $invoice->warehouse_id]);
                    $stock->quantity += $qty;
                    $stock->save();
                              
                }
            });
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
            // لا تستخدم dd في الإنتاج
            return back()->withInput()->with('error', 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage());
        }
        }
    }
}

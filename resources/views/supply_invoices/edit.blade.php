@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">✏️ تعديل فاتورة توريد: {{ $invoice->invoice_number }}</h2>

    <form action="{{ route('supply_invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- معلومات الفاتورة --}}
        <div class="mb-4">
            <label>رقم الفاتورة:</label>
            <input type="text" name="invoice_number" class="form-control" value="{{ $invoice->invoice_number }}" required>
        </div>

        <div class="mb-4">
            <label>تاريخ الفاتورة:</label>
            <input type="date" name="invoice_date" class="form-control" value="{{ $invoice->invoice_date }}" required>
        </div>

        <div class="mb-4">
            <label>المورد:</label>
            <select name="supplier_id" class="form-control" required>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $supplier->id == $invoice->supplier_id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>الشاحنة:</label>
            <select name="truck_id" class="form-control">
                @foreach($trucks as $truck)
                    <option value="{{ $truck->id }}" {{ $truck->id == $invoice->truck_id ? 'selected' : '' }}>
                        {{ $truck->plate_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>المخزن:</label>
            <select name="warehouse_id" class="form-control" required>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ $warehouse->id == $invoice->warehouse_id ? 'selected' : '' }}>
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>ملاحظات:</label>
            <textarea name="notes" class="form-control">{{ $invoice->notes }}</textarea>
        </div>

        <hr>

        {{-- الأصناف --}}
        <h5 class="mt-3 mb-2">📦 تعديل تفاصيل الأصناف</h5>
        <table class="table table-bordered" id="items_table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>عدد المشاطيح</th>
                    <th>الكمية/مشطاح</th>
                    <th>الوزن الكلي</th>
                    <th>❌</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $i => $item)
                    <tr>
                        <td>
                            <select name="items[{{ $i }}][product_id]" class="form-control" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="items[{{ $i }}][unit_id]" class="form-control" required>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ $unit->id == $item->unit_id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="items[{{ $i }}][pallets_count]" class="form-control" value="{{ $item->pallets_count }}" required></td>
                        <td><input type="number" name="items[{{ $i }}][quantity_per_pallet]" class="form-control" value="{{ $item->quantity_per_pallet }}" required></td>
                        <td><input type="number" name="items[{{ $i }}][total_weight]" class="form-control" value="{{ $item->total_weight }}" required></td>
                        <td><button type="button" class="btn btn-danger remove_row">✖</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary" id="add_row">➕ إضافة صنف</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">💾 حفظ التعديلات</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
@include('supply_invoices.partials.dynamic_rows_script')
@endsection

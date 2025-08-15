@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">➕ تسجيل فاتورة توريد جديدة</h2>

    <form action="{{ route('supply_invoices.store') }}" method="POST">
        @csrf

        {{-- معلومات الفاتورة --}}
        <div class="mb-4">
            <label>رقم الفاتورة:</label>
            <input type="text" name="invoice_number" class="form-control" required>
        </div>

        <div class="mb-4">
            <label>تاريخ الفاتورة:</label>
            <input type="date" name="invoice_date" class="form-control" required>
        </div>

        <div class="mb-4">
            <label>المورد:</label>
            <select name="supplier_id" class="form-control" required>
                <option value="">-- اختر المورد --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>الشاحنة:</label>
            <select name="truck_id" class="form-control">
                <option value="">-- اختر الشاحنة --</option>
                @foreach($trucks as $truck)
                    <option value="{{ $truck->id }}">{{ $truck->plate_number }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>المخزن:</label>
            <select name="warehouse_id" class="form-control" required>
                <option value="">-- اختر المخزن --</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>ملاحظات:</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <hr>

        {{-- جدول الأصناف --}}
        <h4 class="mt-4 mb-2">🧾 تفاصيل الأصناف</h4>

        <table class="table table-bordered" id="items_table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>عدد المشاطيح</th>
                    <th>الكمية/مشطاح</th>
                    <th>الوزن الكلي (جم)</th>
                    <th>❌</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][product_id]" class="form-control" required>
                            <option value="">-- اختر --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="items[0][unit_id]" class="form-control" required>
                            <option value="">-- وحدة --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[0][pallets_count]" class="form-control" required></td>
                    <td><input type="number" name="items[0][quantity_per_pallet]" class="form-control" required></td>
                    <td><input type="number" name="items[0][total_weight]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger remove_row">✖</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary" id="add_row">➕ إضافة صنف</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">💾 حفظ الفاتورة</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let rowIdx = 1;
document.getElementById('add_row').addEventListener('click', function () {
    let newRow = document.querySelector('#items_table tbody tr').cloneNode(true);
    newRow.querySelectorAll('select, input').forEach((el) => {
        let name = el.name.replace(/\[\d+\]/, `[${rowIdx}]`);
        el.name = name;
        el.value = '';
    });
    document.querySelector('#items_table tbody').appendChild(newRow);
    rowIdx++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove_row')) {
        if (document.querySelectorAll('#items_table tbody tr').length > 1) {
            e.target.closest('tr').remove();
        }
    }
});
</script>
@endpush

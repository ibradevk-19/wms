@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📥 تسجيل فاتورة توريد جديدة</h3>

    <form method="POST" action="{{ route('supply_vouchers.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>المخزن</label>
                <select name="warehouse_id" class="form-control" required>
                    <option value="">اختر مخزن</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>الرقم المرجعي</label>
                <input type="text" name="reference_no" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>اسم المورد (السائق)</label>
                <input type="text" name="supplier_name" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>تاريخ التوريد</label>
                <input type="date" name="supply_date" class="form-control" required>
            </div>

            <div class="col-md-8 mb-3">
                <label>ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <hr>
        <h5>🧾 الأصناف الموردة</h5>

        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>عدد المشاطيح</th>
                    <th>الكمية/مشطاح</th>
                    <th>الوزن (جم)</th>
                    <th>إزالة</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][product_id]" class="form-control" required>
                            <option value="">اختر صنف</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[0][pallets]" class="form-control" min="1" required></td>
                    <td><input type="number" name="items[0][qty_per_pallet]" class="form-control" min="1" required></td>
                    <td><input type="number" name="items[0][weight_gram]" class="form-control" min="0"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">✖</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="add-row" class="btn btn-secondary mb-3">➕ إضافة صنف</button>
        <br>
        <button type="submit" class="btn btn-primary">💾 تسجيل التوريد</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let rowIdx = 1;
    const productsOptions = `{!! json_encode($products->pluck('name', 'id')) !!}`;

    $('#add-row').on('click', function () {
        let row = `<tr>
            <td>
                <select name="items[${rowIdx}][product_id]" class="form-control" required>
                    <option value="">اختر صنف</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${rowIdx}][pallets]" class="form-control" min="1" required></td>
            <td><input type="number" name="items[${rowIdx}][qty_per_pallet]" class="form-control" min="1" required></td>
            <td><input type="number" name="items[${rowIdx}][weight_gram]" class="form-control" min="0"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">✖</button></td>
        </tr>`;
        $('#items-table tbody').append(row);
        rowIdx++;
    });

    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });
</script>
@endpush

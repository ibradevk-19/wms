@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">🌀 تسجيل تحويل بين مخزنين</h3>

    <form method="POST" action="{{ route('transfer_vouchers.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>المخزن المصدر</label>
                <select name="from_warehouse_id" class="form-control" required>
                    <option value="">اختر مخزن</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>المخزن المستهدف</label>
                <select name="to_warehouse_id" class="form-control" required>
                    <option value="">اختر مخزن</option>
                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>رقم التحويل</label>
                <input type="text" name="reference_no" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>تاريخ التحويل</label>
                <input type="date" name="transfer_date" class="form-control" required>
            </div>

            <div class="col-md-8 mb-3">
                <label>ملاحظات</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <hr>
        <h5>📦 الأصناف المحولة</h5>

        <table class="table table-bordered" id="items-table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>الكمية</th>
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
                    <td><input type="number" name="items[0][quantity]" class="form-control" min="1" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">✖</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="add-row" class="btn btn-secondary mb-3">➕ إضافة صنف</button>
        <br>
        <button type="submit" class="btn btn-primary">💾 تسجيل التحويل</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let rowIdx = 1;

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
            <td><input type="number" name="items[${rowIdx}][quantity]" class="form-control" min="1" required></td>
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

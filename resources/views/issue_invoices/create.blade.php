<!-- resources/views/issue_invoices/create.blade.php -->
@extends('layouts.master')
@section('content')
<div class="container">
    <h1>➕ إضافة فاتورة صرف</h1>

    <form method="POST" action="{{ route('issue-invoices.store') }}">
        @csrf

        <div class="mb-3">
            <label>المخزن:</label>
            <select name="warehouse_id" class="form-control" required>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>الجهة المستفيدة:</label>
            <input type="text" name="issued_to_id" class="form-control" required>

        </div>

        <div class="mb-3">
            <label>التاريخ:</label>
            <input type="date" name="issue_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>الأصناف:</label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الصنف</th>
                        <th>الكمية</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody id="items-table">
                    <tr>
                        <td>
                            <select name="items[0][product_id]" class="form-control">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit->name }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
                        <td><input type="text" name="items[0][remarks]" class="form-control"></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" onclick="addRow()" class="btn btn-sm btn-secondary">➕ صف جديد</button>
        </div>

        <button type="submit" class="btn btn-success">💾 حفظ</button>
    </form>
</div>

<script>
let row = 1;
function addRow() {
    let table = document.getElementById('items-table');
    let newRow = table.rows[0].cloneNode(true);

    newRow.querySelectorAll('input, select').forEach(input => {
        input.name = input.name.replace('[0]', '[' + row + ']');
        input.value = '';
    });

    table.appendChild(newRow);
    row++;
}
</script>
@endsection

@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">📦 قائمة فواتير التوريد</h2>

    {{-- فلترة --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="supplier_id" class="form-control">
                <option value="">-- كل الموردين --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="warehouse_id" class="form-control">
                <option value="">-- كل المخازن --</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 بحث</button>
        </div>
    </form>

    {{-- جدول الفواتير --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>رقم الفاتورة</th>
                <th>التاريخ</th>
                <th>المورد</th>
                <th>المخزن</th>
                <th>الشاحنة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ $invoice->supplier->name ?? '-' }}</td>
                    <td>{{ $invoice->warehouse->name ?? '-' }}</td>
                    <td>{{ $invoice->truck->plate_number ?? '-' }}</td>
                    <td>
                        <a href="{{ route('supply_invoices.show', $invoice) }}" class="btn btn-sm btn-info">👁️ عرض</a>
                        <a href="{{ route('supply_invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">✏️ تعديل</a>
                        <form action="{{ route('supply_invoices.destroy', $invoice) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑 حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">لا توجد فواتير حالياً</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- ترقيم الصفحات --}}
 
</div>
@endsection

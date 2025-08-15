@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 تقرير تعاملات الموردين</h2>

    <form method="GET" action="{{ route('supplier-reports.index') }}" class="row mb-4">
        <div class="col-md-3">
            <label>المورد</label>
            <select name="supplier_id" class="form-control">
                <option value="">-- الكل --</option>
                @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>
                        {{ $sup->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>من تاريخ</label>
            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label>إلى تاريخ</label>
            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label>نوع التعامل</label>
            <select name="type" class="form-control">
                <option value="">-- الكل --</option>
                <option value="supply_invoice" {{ request('type') == 'supply_invoice' ? 'selected' : '' }}>توريد</option>
                <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>دفعة</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary me-2">عرض التقرير</button>
            <a href="{{ route('supplier-reports.export', request()->all()) }}" class="btn btn-success">📥 تصدير Excel</a>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>المورد</th>
                <th>النوع</th>
                <th>المرجع</th>
                <th>التاريخ</th>
                <th>الكمية</th>
                <th>الوصف</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
                <tr>
                    <td>{{ $t->supplier->name }}</td>
                    <td>
                        @switch($t->type)
                            @case('supply_invoice') فاتورة توريد @break
                            @case('payment') دفعة مالية @break
                            @default ملاحظة
                        @endswitch
                    </td>
                    <td>{{ $t->reference }}</td>
                    <td>{{ $t->transaction_date }}</td>
                    <td>{{ number_format($t->amount, 2) }}</td>
                    <td>{{ $t->description }}</td>
                </tr>
            @empty
                <tr><td colspan="6">لا توجد نتائج</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

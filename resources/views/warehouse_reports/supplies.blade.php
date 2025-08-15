@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📥 تقرير التوريدات للمخازن</h3>

    @if($reportData->isEmpty())
        <div class="alert alert-info">لا توجد توريدات خلال الفترة المحددة.</div>
    @else
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>تاريخ التوريد</th>
                <th>رقم الفاتورة</th>
                <th>المخزن</th>
                <th>اسم المورد</th>
                <th>الصنف</th>
                <th>عدد المشاطيح</th>
                <th>الكمية/مشطاح</th>
                <th>إجمالي الكمية</th>
                <th>الوزن (جم)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $voucher)
                @foreach($voucher->items as $item)
                <tr>
                    <td>{{ $voucher->supply_date }}</td>
                    <td>{{ $voucher->reference_no }}</td>
                    <td>{{ $voucher->warehouse->name }}</td>
                    <td>{{ $voucher->supplier_name }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->pallets }}</td>
                    <td>{{ $item->qty_per_pallet }}</td>
                    <td>{{ $item->total_qty }}</td>
                    <td>{{ $item->weight_gram ?? '-' }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ route('warehouse.reports.index') }}" class="btn btn-secondary">↩️ رجوع</a>
</div>
@endsection

@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📤 تقرير الصرفيات من المخازن</h3>

    @if($reportData->isEmpty())
        <div class="alert alert-info">لا توجد صرفيات خلال الفترة المحددة.</div>
    @else
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>تاريخ الصرف</th>
                <th>رقم الفاتورة</th>
                <th>المخزن</th>
                <th>الجهة المستلمة</th>
                <th>الصنف</th>
                <th>الكمية المصروفة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $voucher)
                @foreach($voucher->items as $item)
               
                <tr>
                    <td>{{ $voucher->issue_date }}</td>
                    <td>{{ $voucher->issue_number }}</td>
                    <td>{{ $voucher->warehouse->name }}</td>
                    <td>{{ $voucher->issued_to_id }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ route('warehouse.reports.index') }}" class="btn btn-secondary">↩️ رجوع</a>
</div>
@endsection

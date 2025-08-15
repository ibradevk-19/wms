@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 تقرير الكميات الحالية في المخازن</h3>

    @if($reportData->isEmpty())
        <div class="alert alert-info">لا توجد بيانات حالياً.</div>
    @else
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>المخزن</th>
                <th>الصنف</th>
                <th>الكمية المتوفرة</th>
                <th>الموقع داخل المخزن</th>
                <th>تاريخ آخر حركة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $item)
            <tr>
                <td>{{ $item->warehouse->name }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->location_inside ?? '-' }}</td>
                <td>{{ $item->last_movement_at ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ route('warehouse.reports.index') }}" class="btn btn-secondary">↩️ رجوع إلى اختيار التقرير</a>
@endsection

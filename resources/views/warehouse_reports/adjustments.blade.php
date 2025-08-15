@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">🔍 تقرير الفروقات بعد الجرد</h3>

    @if($reportData->isEmpty())
        <div class="alert alert-info">لا توجد نتائج جرد مسجلة خلال الفترة المحددة.</div>
    @else
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>تاريخ الجرد</th>
                <th>المخزن</th>
                <th>الصنف</th>
                <th>الكمية النظامية</th>
                <th>الكمية الفعلية</th>
                <th>الفرق</th>
                <th>السبب</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $adjustment)
            <tr>
                <td>{{ $adjustment->adjustment_date }}</td>
                <td>{{ $adjustment->warehouse->name }}</td>
                <td>{{ $adjustment->product->name }}</td>
                <td>{{ $adjustment->recorded_quantity }}</td>
                <td>{{ $adjustment->actual_quantity }}</td>
                <td class="{{ $adjustment->actual_quantity > $adjustment->recorded_quantity ? 'text-success' : ($adjustment->actual_quantity < $adjustment->recorded_quantity ? 'text-danger' : '') }}">
                    {{ $adjustment->actual_quantity - $adjustment->recorded_quantity }}
                </td>
                <td>{{ $adjustment->reason ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <a href="{{ route('warehouse.reports.index') }}" class="btn btn-secondary">↩️ رجوع</a>
</div>
@endsection

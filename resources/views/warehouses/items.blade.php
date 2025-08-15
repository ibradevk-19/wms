@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 الأصناف داخل المخزن: {{ $warehouse->name }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>اسم الصنف</th>
                <th>الكمية</th>
                <th>موقع التخزين</th>
                <th>آخر حركة</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->product->name ?? '---' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->location_inside ?? '-' }}</td>
                <td>{{ $item->last_movement_at ?? '---' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">لا توجد أصناف حالياً في هذا المخزن.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">↩️ رجوع</a>
</div>
@endsection

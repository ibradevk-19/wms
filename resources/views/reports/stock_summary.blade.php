@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 تقرير رصيد الأصناف حسب المخازن</h3>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover text-center align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الصنف</th>
                        <th>الوحدة</th>
                        @foreach($warehouses as $warehouse)
                            <th>{{ $warehouse->name }}</th>
                        @endforeach
                        <th class="text-primary fw-bold">المجموع الكلي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="text-start">{{ $product->name }}</td>
                            <td>{{ $product->unit->name ?? '--' }}</td>
                            @php $total = 0; @endphp
                            @foreach($warehouses as $warehouse)
                                @php
                                    $qty = $product->stocks->where('warehouse_id', $warehouse->id)->first()->quantity ?? 0;
                                    $total += $qty;
                                @endphp
                                <td>{{ $qty }}</td>
                            @endforeach
                            <td class="fw-bold text-primary">{{ $total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 تقرير رصيد الأصناف حسب المخزن</h3>

    <form method="GET" class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <label for="warehouse_id" class="col-form-label">اختر المخزن:</label>
        </div>
        <div class="col-auto">
            <select name="warehouse_id" id="warehouse_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- اختر --</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ $selectedWarehouse == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($selectedWarehouse)
        <div class="card">
            <div class="card-header bg-primary text-white">
                رصيد الأصناف في: {{ $warehouses->firstWhere('id', $selectedWarehouse)?->name }}
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>الصنف</th>
                            <th>الوحدة</th>
                            <th>الكمية بالمخزن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php $stock = $product->stocks->first(); @endphp
                            <tr>
                                <td class="text-start">{{ $product->name }}</td>
                                <td>{{ $product->unit->name ?? '--' }}</td>
                                <td class="text-primary fw-bold">
                                    {{ $stock->quantity ?? 0 }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            الرجاء اختيار مخزن لعرض رصيد الأصناف فيه.
        </div>
    @endif
</div>
@endsection

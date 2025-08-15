@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📋 الجرد اليدوي للمخزن: {{ $warehouse->name }}</h3>

    <form method="POST" action="{{ route('inventory.adjustment.store') }}">
        @csrf

        <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">

        <div class="row mb-3">
            <div class="col-md-4">
                <label>تاريخ الجرد</label>
                <input type="date" name="adjustment_date" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>الصنف</th>
                    <th>الكمية النظامية</th>
                    <th>الكمية الفعلية</th>
                    <th>سبب الفارق</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>
                        {{ $item->product->name }}
                        <input type="hidden" name="adjustments[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                    </td>
                    <td>
                        {{ $item->quantity }}
                        <input type="hidden" name="adjustments[{{ $loop->index }}][recorded_quantity]" value="{{ $item->quantity }}">
                    </td>
                    <td>
                        <input type="number" name="adjustments[{{ $loop->index }}][actual_quantity]" class="form-control" min="0" value="{{ $item->quantity }}" required>
                    </td>
                    <td>
                        <input type="text" name="adjustments[{{ $loop->index }}][reason]" class="form-control" placeholder="مثال: تالف - مفقود - زيادة غير مسجلة">
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">لا توجد أصناف مسجلة لهذا المخزن.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">💾 حفظ الجرد</button>
        <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>
@endsection

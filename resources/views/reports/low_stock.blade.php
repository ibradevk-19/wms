@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">⚠️ تقرير الأصناف القريبة من حد النفاد</h3>

    @if($products->count() > 0)
        <div class="card">
            <div class="card-header bg-danger text-white">
                قائمة الأصناف التي تجاوزت أو قاربت حد التنبيه
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-danger">
                        <tr>
                            <th>الصنف</th>
                            <th>الوحدة</th>
                            <th>حد التنبيه</th>
                            <th>الرصيد الحالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->unit->name ?? '--' }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ $product->alert_threshold }}
                                </span>
                            </td>
                            <td>
                                <span class="text-danger fw-bold">
                                    {{ $product->total_quantity ?? 0}}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-success">
            ✅ لا توجد أصناف قريبة من حد النفاد.
        </div>
    @endif
</div>
@endsection

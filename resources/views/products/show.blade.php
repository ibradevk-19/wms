@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📄 تفاصيل الصنف: {{ $product->name }}</h3>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            معلومات الصنف
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>الاسم:</strong> {{ $product->name }}
                </div>
                <div class="col-md-6">
                    <strong>الكود:</strong> {{ $product->code }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>التصنيف:</strong> {{ optional($product->category)->name ?? '---' }}
                </div>
                <div class="col-md-6">
                    <strong>الوحدة:</strong> {{ optional($product->unit)->name ?? '---' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>🔔 حد التنبيه:</strong> 
                    <span class="badge bg-warning text-dark">{{ $product->alert_threshold }}</span>
                </div>
                <div class="col-md-6">
                    <strong>الوصف:</strong> {{ $product->description ?? '---' }}
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            📦 الرصيد حسب المخازن
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>المخزن</th>
                        <th>الكمية</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->stocks as $stock)
                        @php
                            $low = $stock->quantity <= $product->alert_threshold;
                        @endphp
                        <tr class="{{ $low ? 'table-danger' : '' }}">
                            <td>{{ $stock->warehouse->name }}</td>
                            <td>
                                <span class="badge {{ $low ? 'bg-danger' : 'bg-success' }}">
                                    {{ $stock->quantity }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        🔙 رجوع إلى قائمة الأصناف
    </a>
</div>
@endsection

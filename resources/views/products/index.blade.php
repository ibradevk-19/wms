@extends('layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">📦 قائمة الأصناف</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            ➕ إضافة صنف جديد
        </a>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>الكود</th>
                <th>التصنيف</th>
                <th>الوحدة</th>
                <th>حد التنبيه</th>
                <th>الرصيد الكلي</th>
                <th>الخيارات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            @php
                $stock = $product->totalStock();
                $isLow = $stock <= $product->alert_threshold;
            @endphp
            <tr class="{{ $isLow ? 'table-danger' : '' }}">
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->code }}</td>
                <td>{{ optional($product->category)->name }}</td>
                <td>{{ optional($product->unit)->name }}</td>
                <td>{{ $product->alert_threshold }}</td>
                <td>
                    <span class="badge {{ $isLow ? 'bg-danger' : 'bg-success' }}">
                        {{ $stock }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">👁️ عرض</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">✏️ تعديل</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑️ حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection

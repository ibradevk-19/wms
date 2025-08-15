@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ تعديل صنف: {{ $product->name }}</h3>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>اسم الصنف</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>كود الصنف</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $product->code) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>التصنيف</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- اختر التصنيف --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>الوحدة</label>
            <select name="unit_id" class="form-control" required>
                <option value="">-- اختر الوحدة --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>حد التنبيه</label>
            <input type="number" name="alert_threshold" class="form-control" value="{{ old('alert_threshold', $product->alert_threshold) }}" required>
        </div>

        <div class="form-group mb-3">
            <label>الوصف (اختياري)</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">💾 تحديث</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">↩️ إلغاء</a>
    </form>
</div>
@endsection

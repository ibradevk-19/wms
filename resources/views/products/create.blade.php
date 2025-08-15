@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">➕ إضافة صنف جديد</h3>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label>اسم الصنف</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>كود الصنف</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>التصنيف</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- اختر التصنيف --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>الوحدة</label>
            <select name="unit_id" class="form-control" required>
                <option value="">-- اختر الوحدة --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label>حد التنبيه</label>
            <input type="number" name="alert_threshold" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>الوصف (اختياري)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">↩️ إلغاء</a>
    </form>
</div>
@endsection

@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📝 تعديل بيانات المخزن</h3>

    <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>اسم المخزن</label>
            <input type="text" name="name" class="form-control" value="{{ $warehouse->name }}" required>
        </div>

        <div class="form-group mb-3">
            <label>رمز المخزن</label>
            <input type="text" name="code" class="form-control" value="{{ $warehouse->code }}" required>
        </div>

        <div class="form-group mb-3">
            <label>الموقع</label>
            <input type="text" name="location" class="form-control" value="{{ $warehouse->location }}">
        </div>

        <div class="form-group mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ $warehouse->status === 'active' ? 'selected' : '' }}>نشط</option>
                <option value="inactive" {{ $warehouse->status === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                <option value="under_maintenance" {{ $warehouse->status === 'under_maintenance' ? 'selected' : '' }}>تحت الصيانة</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>الطاقة الاستيعابية</label>
            <input type="number" name="capacity" class="form-control" value="{{ $warehouse->capacity }}">
        </div>

        <div class="form-group mb-3">
            <label>ملاحظات</label>
            <textarea name="notes" class="form-control" rows="3">{{ $warehouse->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">💾 تحديث</button>
        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">↩️ رجوع</a>
    </form>
</div>
@endsection

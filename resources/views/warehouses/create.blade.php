@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">➕ إضافة مخزن جديد</h3>

    <form action="{{ route('warehouses.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label>اسم المخزن</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>رمز المخزن</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>الموقع</label>
            <input type="text" name="location" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control" required>
                <option value="active">نشط</option>
                <option value="inactive">غير نشط</option>
                <option value="under_maintenance">تحت الصيانة</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>الطاقة الاستيعابية (وحدة: مشاطيح / متر مكعب)</label>
            <input type="number" name="capacity" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>ملاحظات</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">↩️ إلغاء</a>
    </form>
</div>
@endsection

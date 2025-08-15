@extends('layouts.master')

@section('content')
<div class="container">
    <h1>{{ isset($truck) ? '✏️ تعديل شاحنة' : '➕ إضافة شاحنة' }}</h1>

    <form action="{{ isset($truck) ? route('trucks.update', $truck) : route('trucks.store') }}" method="POST">
        @csrf
        @if(isset($truck)) @method('PUT') @endif

        <div class="mb-3">
            <label>رقم اللوحة</label>
            <input type="text" name="plate_number" class="form-control" value="{{ old('plate_number', $truck->plate_number ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>اسم السائق</label>
            <input type="text" name="driver_name" class="form-control" value="{{ old('driver_name', $truck->driver_name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>رقم الهاتف</label>
            <input type="text" name="driver_phone" class="form-control" value="{{ old('driver_phone', $truck->driver_phone ?? '') }}">
        </div>

        <div class="mb-3">
            <label>الحالة</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active', $truck->is_active ?? 1) == 1 ? 'selected' : '' }}>نشطة</option>
                <option value="0" {{ old('is_active', $truck->is_active ?? 1) == 0 ? 'selected' : '' }}>غير نشطة</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($truck) ? '💾 حفظ التعديلات' : '📥 حفظ' }}</button>
    </form>
</div>
@endsection

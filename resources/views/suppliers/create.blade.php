@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">➕ إضافة مورد جديد</h1>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>اسم المورد</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label>المدينة</label>
            <input type="text" name="city" class="form-control">
        </div>
        <div class="mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control">
                <option value="active">نشط</option>
                <option value="inactive">غير نشط</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">💾 حفظ</button>
    </form>
</div>
@endsection
